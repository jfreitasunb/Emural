<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';

seg_proteger(false);

if(isset($_POST['aluno_id']) && isset($_POST['turma_id'])) {
	$aluno = new stdClass();
	$aluno->codigo = (int) $_POST['aluno_id'];

	$turmasBO = new TurmasBO();
	$turma = $turmasBO->retornaPorCodigo((int) $_POST['turma_id']);

	// Somente o professor da turma pode consultar as médias.
	$autenticacaoBO = new AutenticacaoBO();
	$autenticacaoBO->verificarProfessor($turma !== null ? $turma->professor : null);

	$notasBO = new NotasBO();
	$nota_final = $notasBO->retornaMediaMencao($turma,$aluno);

	echo h($nota_final["media"]);
} else {
	echo "";
}
?>
