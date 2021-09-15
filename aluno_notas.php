<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$turmasBO = new TurmasBO();
$semestresBO = new SemestresBO();

/*require_once $ROOT_PATH.'lib/alunosBO.php';
$alunosBO = new AlunosBO();
$aluno = $alunosBO->retornaPorCodigo(8);
session_start();
$_SESSION["aluno"] = serialize($aluno);/**/

$aluno = $autenticacaoBO->verificarAluno();

if($_POST) {
}

$semestre = $semestresBO->retornaUltimoSemestre();

$tpl_main = $templateBO->carregarPaginaAlunoNotas($aluno);

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('aluno_notas.tpl');

$tpl->setVariable(array(
	"semestre"  => $semestre->semestre,
	"ano"  => $semestre->ano
));

$tpl_tabela = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl_tabela->loadTemplateFile('tabela_com_titulo.tpl');

$templateBO->iniciarTabela($tpl_tabela);

$turmasBO->preencherNotasAluno($tpl_tabela,$aluno,$semestre);

$tpl->setVariable(array(
	'conteudo'  => $tpl_tabela->get()
));

$templateBO->iniciarAlunoNotas($tpl);


$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>