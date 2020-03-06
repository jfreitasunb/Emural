<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';

if(isset($_POST['aluno_id']) && isset($_POST['turma_id'])) {
	$aluno->codigo = $_POST['aluno_id'];

	$turmasBO = & new TurmasBO();
	$turma = $turmasBO->retornaPorCodigo($_POST['turma_id']);

	$notasBO = & new NotasBO();
	$nota_final = $notasBO->retornaMediaMencao($turma,$aluno);

	echo $nota_final["media"];
} else {
	echo "";
}
?>