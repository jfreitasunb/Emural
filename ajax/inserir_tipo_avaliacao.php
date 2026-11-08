<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/codigo_itemBO.php';

seg_proteger(false);

$autenticacaoBO = new AutenticacaoBO();
$autenticacaoBO->verificarProfessor();

$string = isset($_POST['insertString']) ? trim($_POST['insertString']) : '';

$tipo_avaliacao = null;
if (strlen($string)) {
	$codigoItemBO = new CodigoItemBO();
	$tipo_avaliacao = $codigoItemBO->inserirTipoAvaliacao($string);
}

// Resposta em texto puro (usada em .val() no JavaScript).
header('Content-Type: text/plain; charset=utf-8');

if($tipo_avaliacao != null) {
	echo $tipo_avaliacao->descricao;
} else
	echo null;
?>
