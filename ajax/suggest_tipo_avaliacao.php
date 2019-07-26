<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/codigo_itemBO.php';

$string = $_POST['queryString'];
//echo $string."<br>";
if(strlen($string) > 0) {
	$codigoItemBO = new CodigoItemBO();
	$itens = & $codigoItemBO->retornaAutoSuggestTipoAvaliacao($string);

	if(count($itens)) {
		echo '<ul class="suggest_box">';
		foreach($itens as $item)
		{
         	echo '<li class="suggest_item">'.$item->descricao.'</li>';
		}
		echo '</ul>';
	} else {
		echo '';
	}
}
?>