<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

if ($_POST && isset($_POST['user'])) {
	$pessoasBO = & new PessoasBO();

	$pessoa = & $pessoasBO->retornaPorUsuario($_POST['user']);

	if ($pessoa !== null) {
		unset($pessoa->senha);

		$json = json_encode($pessoa);

		echo $json;
	}
}
?>