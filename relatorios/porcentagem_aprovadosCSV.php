<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
seg_proteger(false);

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

	$lista = $composicarTurmasBO->retornaArrayPorcentagemAprovados($dados);

	header("Content-Type: text/csv; charset=utf-8"); 
	header('Content-Disposition: attachment; filename="relatorio.csv"');
	header("X-Content-Type-Options: nosniff");

	RelaroriosBO::getCSVComTitulo($lista);
}
?>