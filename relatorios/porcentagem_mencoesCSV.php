<?php
require_once '../conf/default.php';

require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/relatoriosBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';

$autenticacaoBO = new AutenticacaoBO();
$composicarTurmasBO = new ComposicaoTurmasBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

if($_POST) {
	$dados->inicio = $_POST['ano_semestre_inicio'];
	$dados->fim = $_POST['ano_semestre_fim'];
	$dados->disciplina = $_POST['disciplina'];
	$dados->opcao_curso = $_POST['opcao_curso'];

	$lista = $composicarTurmasBO->retornaArrayPorcentagemMencoes($dados);

	header("Content-type: application/csv"); 
	header("Content-Disposition: \"inline; filename=relatorio.csv\"");

	RelaroriosBO::getCSVComTitulo($lista);
}
?>