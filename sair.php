<?php
require_once 'conf/default.php';
require_once $ROOT_PATH."lib/linkBO.php";
require_once $ROOT_PATH."lib/autenticacaoBO.php";

require_once 'HTTP.php';

$autenticacaoBO = & new AutenticacaoBO();
$autenticacaoBO->logout();

$linkBO = & new LinkBO();
HTTP::redirect($linkBO->getIndex());
?>