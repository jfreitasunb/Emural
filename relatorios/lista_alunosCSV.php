<?php
require_once '../conf/default.php';

require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/relatoriosBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';

$autenticacaoBO = new AutenticacaoBO();
$turmasBO = new TurmasBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

if($_POST) {
	$dados->ano_semestre = $_POST['ano_semestre'];
	$dados->disciplina = $_POST['disciplina'];

	if(isset($_POST['turma']))
		$dados->turma = $_POST['turma'];
	else
		$dados->turma = null;

	if(isset($_POST['aprovados']))
		$dados->apenas_aprovados = true;
	else
		$dados->apenas_aprovados = false;

	$lista = & $turmasBO->retornaArrayListaAlunos($dados);

	header("Content-type: application/csv"); 
	header("Content-Disposition: \"inline; filename=relatorio.csv\"");

	RelaroriosBO::getCSV($lista);
}
?>