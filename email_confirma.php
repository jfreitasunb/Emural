<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH."lib/autenticacaoBO.php";
require_once $ROOT_PATH.'lib/linkBO.php';

$pessoasBO = new PessoasBO();

$codigo_confirmacao = NULL;
if($_GET && isset($_GET['confirmacao'])) {
	$codigo_confirmacao = $_GET['confirmacao'];
}

$autenticacaoBO = new AutenticacaoBO();
$autenticacaoBO->logout();

$pessoasBO->confirmarEmail($codigo_confirmacao);

$linkBO = new LinkBO();

HTTP::redirect($linkBO->getMoodle());
?>