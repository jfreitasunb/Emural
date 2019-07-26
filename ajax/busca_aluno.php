<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/alunosBO.php';

if ($_POST && strlen($busca = $_POST['busca'])) {
	$alunosBO = & new AlunosBO();
	$aluno = null;

	if (is_numeric($busca)) {
		$aluno = & $alunosBO->retornaPorMatricula($busca);
	} else {
		$aluno = & $alunosBO->retornaPorEmail($busca);
	}

	echo json_encode($aluno);
}
?>