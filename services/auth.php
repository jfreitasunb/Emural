<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';

// Serviço consumido pelo Moodle (servidor a servidor). Se a lista de IPs
// permitidos estiver configurada em conf/default.php, ela é exigida.
if (isset($SERVICOS_IPS_PERMITIDOS) && is_array($SERVICOS_IPS_PERMITIDOS) && count($SERVICOS_IPS_PERMITIDOS)
		&& !in_array($_SERVER['REMOTE_ADDR'], $SERVICOS_IPS_PERMITIDOS, true)) {
	header('HTTP/1.1 403 Forbidden');
	exit;
}

if ($_POST && isset($_POST['user']) && isset($_POST['password'])) {
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	
	// headers to tell that result is JSON
	header('Content-type: application/json');

	$autenticacaoBO = new AutenticacaoBO();
	
	$retorno = $autenticacaoBO->pode_logar($_POST['user'], $_POST['password']);

	$json = json_encode($retorno);
}
?>
