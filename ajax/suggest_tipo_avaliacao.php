<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/codigo_itemBO.php';

seg_proteger(false);

$autenticacaoBO = new AutenticacaoBO();
$autenticacaoBO->verificarProfessor();

$string = isset($_POST['queryString']) ? $_POST['queryString'] : '';

if(strlen($string) > 0) {
	$codigoItemBO = new CodigoItemBO();
	$itens = $codigoItemBO->retornaAutoSuggestTipoAvaliacao($string);

	if(count($itens)) {
		echo '<ul class="suggest_box">';
		foreach($itens as $item)
		{
         	echo '<li class="suggest_item">'.h($item->descricao).'</li>';
		}
		echo '</ul>';
	} else {
		echo '';
	}
}
?>
