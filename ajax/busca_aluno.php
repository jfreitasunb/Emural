<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/alunosBO.php';

seg_proteger(false);

// Somente o coordenador pode consultar dados de alunos.
$autenticacaoBO = new AutenticacaoBO();
$autenticacaoBO->verificarCoordenador();

header('Content-Type: application/json; charset=utf-8');

if ($_POST && isset($_POST['busca']) && strlen($busca = trim($_POST['busca']))) {
	$alunosBO = new AlunosBO();
	$aluno = null;

	if (is_numeric($busca)) {
		$aluno = $alunosBO->retornaPorMatricula($busca);
	} else {
		$aluno = $alunosBO->retornaPorEmail($busca);
	}

	$retorno = null;

	if ($aluno !== null) {
		// Nunca devolve hash de senha nem tokens.
		$retorno = new stdClass();
		$retorno->codigo = $aluno->codigo;
		$retorno->matricula = $aluno->matricula;
		$retorno->nome = $aluno->nome;
		$retorno->email = $aluno->email;
		$retorno->email_valido = $aluno->email_valido;
	}

	echo json_encode($retorno);
}
?>
