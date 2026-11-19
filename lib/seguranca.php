<?php
/**
 * Funções de segurança compartilhadas: sessão, CSRF, escape de HTML,
 * tokens aleatórios, hash de senhas e limite de tentativas de login.
 */

if (!defined('SEG_CSRF_CAMPO')) {
	define('SEG_CSRF_CAMPO', 'csrf_token');
	define('SEG_LOGIN_MAX_TENTATIVAS', 5);
	define('SEG_LOGIN_IP_MAX_TENTATIVAS', 30);
	define('SEG_LOGIN_JANELA_SEGUNDOS', 900);
	// Validade do link de redefinição de senha (24 horas).
	define('SEG_VALIDADE_LINK_SENHA', 86400);
	// Tempo máximo de inatividade da sessão (2 horas).
	define('SEG_SESSAO_TIMEOUT', 7200);
}


/**
 * Envia cabeçalhos HTTP básicos de segurança.
 */
function seg_enviar_cabecalhos()
{
	if (headers_sent()) {
		return;
	}

	header('X-Frame-Options: DENY');
	header('X-Content-Type-Options: nosniff');
	header('Referrer-Policy: strict-origin-when-cross-origin');

	if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
		header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
	}
}


/**
 * Inicia a sessão (uma única vez) com cookies endurecidos e controle de inatividade.
 */
function seg_iniciar_sessao()
{
	if (session_status() !== PHP_SESSION_ACTIVE) {
		ini_set('session.use_strict_mode', '1');
		ini_set('session.use_only_cookies', '1');
		ini_set('session.cookie_httponly', '1');

		if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
			ini_set('session.cookie_secure', '1');
		}

		if (PHP_VERSION_ID >= 70300) {
			ini_set('session.cookie_samesite', 'Lax');
		}

		session_start();
	}

	if (isset($_SESSION['seg_ultima_atividade']) && (time() - (int) $_SESSION['seg_ultima_atividade']) > SEG_SESSAO_TIMEOUT) {
		session_unset();
		session_regenerate_id(true);
	}

	$_SESSION['seg_ultima_atividade'] = time();
}


/**
 * Valida e normaliza um endereço de e-mail, rejeitando caracteres de controle/CRLF.
 * Retorna o e-mail normalizado em minúsculas ou false se inválido.
 */
function seg_validar_email($email)
{
	if (!is_string($email)) {
		return false;
	}

	if (preg_match('/[\x00-\x1F\x7F]/', $email)) {
		return false;
	}

	$email = strtolower(trim($email));

	if ($email === '' || strlen($email) > 80) {
		return false;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return false;
	}

	return $email;
}


/**
 * Valida a força mínima de uma senha (8+ caracteres, maiúscula, minúscula, número e especial).
 */
function seg_validar_senha_forte($senha)
{
	if (!is_string($senha) || strlen($senha) < 8) {
		return false;
	}

	return preg_match('@[A-Z]@', $senha)
		&& preg_match('@[a-z]@', $senha)
		&& preg_match('@[0-9]@', $senha)
		&& preg_match('@[^\w]@', $senha);
}


/**
 * Calcula hash SHA-256 de um token para armazenamento seguro no banco.
 */
function seg_hash_token($token)
{
	return hash('sha256', (string) $token);
}


/**
 * Escapa um valor para saída em HTML (conteúdo ou atributo).
 */
function h($valor)
{
	if ($valor === null) {
		return '';
	}

	return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


/**
 * Gera um token hexadecimal criptograficamente seguro.
 */
function seg_token_aleatorio($bytes = 16)
{
	if (function_exists('random_bytes')) {
		return bin2hex(random_bytes($bytes));
	}

	if (function_exists('openssl_random_pseudo_bytes')) {
		$forte = false;
		$aleatorio = openssl_random_pseudo_bytes($bytes, $forte);
		if ($aleatorio !== false && $forte) {
			return bin2hex($aleatorio);
		}
	}

	throw new Exception("Nenhuma fonte de aleatoriedade segura disponível.");
}


/**
 * Inteiro aleatório seguro em [min, max].
 */
function seg_inteiro_aleatorio($min, $max)
{
	if (function_exists('random_int')) {
		return random_int($min, $max);
	}

	$intervalo = $max - $min + 1;
	$valor = hexdec(seg_token_aleatorio(4));

	return $min + ($valor % $intervalo);
}


/**
 * Comparação de strings em tempo constante.
 */
function seg_comparar($conhecido, $informado)
{
	if (!is_string($conhecido) || !is_string($informado) || $conhecido === '') {
		return false;
	}

	if (function_exists('hash_equals')) {
		return hash_equals($conhecido, $informado);
	}

	if (strlen($conhecido) !== strlen($informado)) {
		return false;
	}

	$resultado = 0;
	for ($i = 0; $i < strlen($conhecido); $i++) {
		$resultado |= ord($conhecido[$i]) ^ ord($informado[$i]);
	}

	return $resultado === 0;
}


/**
 * Gera o hash de uma senha para armazenamento.
 */
function seg_hash_senha($senha)
{
	GLOBAL $SENHAS_CODIFICADAS;

	if (isset($SENHAS_CODIFICADAS) && !$SENHAS_CODIFICADAS) {
		return $senha;
	}

	return password_hash($senha, PASSWORD_DEFAULT);
}


/**
 * Verifica uma senha contra o hash armazenado. Aceita tanto hashes
 * de password_hash() quanto os hashes antigos gerados por crypt().
 */
function seg_verificar_senha($senha, $hash)
{
	GLOBAL $SENHAS_CODIFICADAS;

	if (!is_string($hash) || strlen($hash) == 0 || !is_string($senha) || strlen($senha) == 0) {
		return false;
	}

	if (isset($SENHAS_CODIFICADAS) && !$SENHAS_CODIFICADAS) {
		return seg_comparar($hash, $senha);
	}

	return password_verify($senha, $hash);
}


/**
 * Indica se um hash de senha deve ser regerado com o algoritmo atual.
 */
function seg_senha_precisa_rehash($hash)
{
	GLOBAL $SENHAS_CODIFICADAS;

	if (isset($SENHAS_CODIFICADAS) && !$SENHAS_CODIFICADAS) {
		return false;
	}

	return password_needs_rehash($hash, PASSWORD_DEFAULT);
}


/* ------------------------------------------------------------------ */
/* CSRF                                                                */
/* ------------------------------------------------------------------ */

function seg_csrf_token()
{
	seg_iniciar_sessao();

	if (empty($_SESSION[SEG_CSRF_CAMPO])) {
		$_SESSION[SEG_CSRF_CAMPO] = seg_token_aleatorio(32);
	}

	return $_SESSION[SEG_CSRF_CAMPO];
}


function seg_csrf_rotacionar()
{
	seg_iniciar_sessao();
	$_SESSION[SEG_CSRF_CAMPO] = seg_token_aleatorio(32);
	$GLOBALS['seg_csrf_atual'] = $_SESSION[SEG_CSRF_CAMPO];

	return $_SESSION[SEG_CSRF_CAMPO];
}


function seg_csrf_valido($informado)
{
	return seg_comparar(seg_csrf_token(), (string) $informado);
}


function seg_csrf_negar()
{
	header('HTTP/1.1 403 Forbidden');
	echo "Requisição inválida (token de segurança ausente ou expirado). Volte à página anterior, recarregue-a e tente novamente.";
	exit;
}


/**
 * Valida o token CSRF de requisições POST (campo de formulário ou
 * cabeçalho X-CSRF-Token, usado pelas chamadas AJAX).
 */
function seg_csrf_validar_post()
{
	if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
		return;
	}

	$informado = '';
	if (isset($_POST[SEG_CSRF_CAMPO])) {
		$informado = $_POST[SEG_CSRF_CAMPO];
	} elseif (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
		$informado = $_SERVER['HTTP_X_CSRF_TOKEN'];
	}

	if (!seg_csrf_valido($informado)) {
		seg_csrf_negar();
	}

	unset($_POST[SEG_CSRF_CAMPO]);
}


/**
 * Valida o token CSRF em ações executadas via GET (ex.: exclusões).
 */
function seg_csrf_validar_get()
{
	$informado = isset($_GET[SEG_CSRF_CAMPO]) ? $_GET[SEG_CSRF_CAMPO] : '';

	if (!seg_csrf_valido($informado)) {
		seg_csrf_negar();
	}
}


/**
 * Insere o token CSRF em todos os formulários e configura o jQuery
 * para enviá-lo nas requisições AJAX.
 */
function seg_csrf_injetar($html)
{
	if (stripos($html, '<form') === false && stripos($html, '</body>') === false) {
		return $html;
	}

	// Não inicia sessão aqui (estamos dentro do callback de saída).
	if (isset($_SESSION[SEG_CSRF_CAMPO])) {
		$token = h($_SESSION[SEG_CSRF_CAMPO]);
	} elseif (isset($GLOBALS['seg_csrf_atual'])) {
		$token = h($GLOBALS['seg_csrf_atual']);
	} else {
		return $html;
	}

	$campo = '<input type="hidden" name="'.SEG_CSRF_CAMPO.'" value="'.$token.'">';
	$html = preg_replace('/(<form\b[^>]*>)/i', '$1'.$campo, $html);

	$script = '<script>if(window.jQuery){jQuery.ajaxSetup({headers:{"X-CSRF-Token":"'.$token.'"}});}</script>';
	$html = preg_replace('/<\/body>/i', $script.'</body>', $html, 1);

	return $html;
}


/**
 * Ponto de entrada usado por todas as páginas: inicia a sessão,
 * exige token CSRF em POST e injeta o token na saída HTML.
 */
function seg_proteger($injetar_saida = true)
{
	seg_enviar_cabecalhos();
	seg_iniciar_sessao();
	$GLOBALS['seg_csrf_atual'] = seg_csrf_token();
	seg_csrf_validar_post();

	if ($injetar_saida) {
		ob_start('seg_csrf_injetar');
	}
}


/* ------------------------------------------------------------------ */
/* Limite de tentativas (login, recuperação de senha, cadastro)        */
/* ------------------------------------------------------------------ */

function seg_ip_cliente()
{
	return isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : 'cli';
}


function seg_diretorio_limites()
{
	GLOBAL $ROOT_PATH;

	if (isset($ROOT_PATH) && is_string($ROOT_PATH) && is_dir($ROOT_PATH.'log') && is_writable($ROOT_PATH.'log')) {
		$diretorio = $ROOT_PATH.'log'.DIRECTORY_SEPARATOR.'.ratelimit';
	} else {
		$sufixo = isset($ROOT_PATH) ? substr(sha1((string) $ROOT_PATH), 0, 12) : 'default';
		$diretorio = sys_get_temp_dir().DIRECTORY_SEPARATOR.'emural_rl_'.$sufixo;
	}

	if (!is_dir($diretorio)) {
		@mkdir($diretorio, 0700, true);
	}

	return $diretorio;
}


function seg_arquivo_limite($acao, $chave)
{
	$diretorio = seg_diretorio_limites();

	return $diretorio.DIRECTORY_SEPARATOR.sha1($acao.'|'.strtolower(trim((string) $chave)));
}


function seg_ler_limite($acao, $chave, $janela)
{
	$arquivo = seg_arquivo_limite($acao, $chave);
	$tentativas = array();

	if (is_file($arquivo) && !is_link($arquivo)) {
		$conteudo = @file_get_contents($arquivo);
		$lista = $conteudo ? json_decode($conteudo, true) : null;
		if (is_array($lista)) {
			$limite = time() - (int) $janela;
			foreach ($lista as $instante) {
				if ((int) $instante > $limite) {
					$tentativas[] = (int) $instante;
				}
			}
		}
	}

	return $tentativas;
}


function seg_limite_excedido($acao, $chave, $max, $janela)
{
	return count(seg_ler_limite($acao, $chave, $janela)) >= (int) $max;
}


function seg_limite_registrar($acao, $chave, $janela)
{
	$tentativas = seg_ler_limite($acao, $chave, $janela);
	$tentativas[] = time();

	@file_put_contents(seg_arquivo_limite($acao, $chave), json_encode($tentativas), LOCK_EX);
}


function seg_limite_limpar($acao, $chave)
{
	$arquivo = seg_arquivo_limite($acao, $chave);
	if (is_file($arquivo) && !is_link($arquivo)) {
		@unlink($arquivo);
	}
}


function seg_login_bloqueado($usuario)
{
	$ip = seg_ip_cliente();
	$chave_par = $ip.'|'.strtolower(trim((string) $usuario));

	return seg_limite_excedido('login_par', $chave_par, SEG_LOGIN_MAX_TENTATIVAS, SEG_LOGIN_JANELA_SEGUNDOS)
		|| seg_limite_excedido('login_ip', $ip, SEG_LOGIN_IP_MAX_TENTATIVAS, SEG_LOGIN_JANELA_SEGUNDOS);
}


function seg_login_registrar_falha($usuario)
{
	$ip = seg_ip_cliente();
	$chave_par = $ip.'|'.strtolower(trim((string) $usuario));

	seg_limite_registrar('login_par', $chave_par, SEG_LOGIN_JANELA_SEGUNDOS);
	seg_limite_registrar('login_ip', $ip, SEG_LOGIN_JANELA_SEGUNDOS);
}


function seg_login_limpar_falhas($usuario)
{
	$ip = seg_ip_cliente();
	$chave_par = $ip.'|'.strtolower(trim((string) $usuario));

	seg_limite_limpar('login_par', $chave_par);
}
?>
