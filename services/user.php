<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

seg_enviar_cabecalhos();

// Serviço consumido pelo Moodle (servidor a servidor): fail-closed se a lista
// de IPs permitidos não estiver configurada em conf/default.php.
if (!isset($SERVICOS_IPS_PERMITIDOS) || !is_array($SERVICOS_IPS_PERMITIDOS) || !count($SERVICOS_IPS_PERMITIDOS)
		|| !in_array($_SERVER['REMOTE_ADDR'], $SERVICOS_IPS_PERMITIDOS, true)) {
	header('HTTP/1.1 403 Forbidden');
	exit;
}

// Se um segredo compartilhado estiver configurado, exige-o no cabeçalho X-Service-Token.
if (isset($SERVICOS_TOKEN) && is_string($SERVICOS_TOKEN) && strlen($SERVICOS_TOKEN) > 0) {
	$token_enviado = isset($_SERVER['HTTP_X_SERVICE_TOKEN']) ? $_SERVER['HTTP_X_SERVICE_TOKEN'] : '';
	if (!seg_comparar($SERVICOS_TOKEN, $token_enviado)) {
		header('HTTP/1.1 403 Forbidden');
		exit;
	}
}

if ($_POST && isset($_POST['user'])) {
	$pessoasBO = new PessoasBO();

	$pessoa = $pessoasBO->retornaPorUsuario($_POST['user']);

	if ($pessoa !== null) {
		// Somente campos públicos: nunca senha, token de redefinição de senha
		// ou código de confirmação de e-mail.
		$retorno = new stdClass();
		$retorno->codigo = $pessoa->codigo;
		$retorno->usuario = $pessoa->usuario;
		$retorno->nome = $pessoa->nome;
		$retorno->tipo = $pessoa->tipo;
		$retorno->codigo_moodle = $pessoa->codigo_moodle;
		$retorno->email = $pessoa->email;
		$retorno->email_valido = $pessoa->email_valido;

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($retorno);
	}
}
?>
