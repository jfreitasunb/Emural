<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';

if ($_POST && isset($_POST['user']) && isset($_POST['password'])) {
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	
	// headers to tell that result is JSON
	header('Content-type: application/json');

	$autenticacaoBO = new AutenticacaoBO();
	
//$retorno = $autenticacaoBO->pode_logar('jfreitas','tugYbykaDO');
	$retorno = $autenticacaoBO->pode_logar($_POST['user'], $_POST['password']);

	$json = json_encode($retorno);
}
?>
