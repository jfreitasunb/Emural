<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/codigo_itemBO.php';

$string = $_POST['insertString'];

$codigoItemBO = & new CodigoItemBO();
$tipo_avaliacao = $codigoItemBO->inserirTipoAvaliacao($string);

if($tipo_avaliacao != null) {
	echo $tipo_avaliacao->descricao;
} else 
	echo null;
?>