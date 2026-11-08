<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/alunosBO.php';

seg_proteger(false);

// Usado apenas na tela do coordenador.
$autenticacaoBO = new AutenticacaoBO();
$autenticacaoBO->verificarCoordenador();

$matricula = isset($_POST['matricula']) ? $_POST['matricula'] : '';

if(strlen($matricula) > 0) {
	$alunosBO = new AlunosBO();
	$aluno = $alunosBO->retornaPorMatricula($matricula);

	if($aluno !== null) {
		echo h($aluno->nome);
	} else {
		echo '';
	}
}
?>
