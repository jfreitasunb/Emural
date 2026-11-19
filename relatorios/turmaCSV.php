<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
seg_proteger(false);

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

$professor = $autenticacaoBO->verificarProfessor($turma !== null ? $turma->professor : null);

$lista = $avaliacoesBO->retornaArrayAlunosProvasMedia($turma);

header("Content-Type: text/csv; charset=utf-8"); 
header('Content-Disposition: attachment; filename="relatorio.csv"');
header("X-Content-Type-Options: nosniff");

RelaroriosBO::getCSVComTitulo($lista);
?>