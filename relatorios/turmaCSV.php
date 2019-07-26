<?php
require_once '../conf/default.php';

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/relatoriosBO.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';

$urlBO = new URLBO();
$turmasBO = new TurmasBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();
$avaliacoesBO = new AvaliacoesBO();

$url = $urlBO->codigoTerceiroNivel();

$semestre = $semestresBO->retornaUltimoSemestre();

$turma = $turmasBO->retornaPorCodigoSemestreAtual($url->codigo,$semestre);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

$lista = $avaliacoesBO->retornaArrayAlunosProvasMedia($turma);

header("Content-type: application/csv"); 
header("Content-Disposition: \"inline; filename=relatorio.csv\"");

RelaroriosBO::getCSVComTitulo($lista);
?>