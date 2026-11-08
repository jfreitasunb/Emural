<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

// Serviço consumido pelo Moodle (servidor a servidor). Se a lista de IPs
// permitidos estiver configurada em conf/default.php, ela é exigida.
if (isset($SERVICOS_IPS_PERMITIDOS) && is_array($SERVICOS_IPS_PERMITIDOS) && count($SERVICOS_IPS_PERMITIDOS)
		&& !in_array($_SERVER['REMOTE_ADDR'], $SERVICOS_IPS_PERMITIDOS, true)) {
	header('HTTP/1.1 403 Forbidden');
	exit;
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
