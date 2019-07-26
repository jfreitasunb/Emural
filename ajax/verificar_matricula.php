<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/alunosBO.php';

$matricula = $_POST['matricula'];
//echo $string."<br>";
if(strlen($matricula) > 0) {
	$alunosBO = new AlunosBO();
	$aluno = & $alunosBO->retornaPorMatricula($matricula);

	if(count($aluno)) {
		//print_r($aluno);
		echo $aluno->nome;
	} else {
		echo '';
	}
}
?>