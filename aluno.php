<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();

/*require_once $ROOT_PATH.'lib/alunosBO.php';
$alunosBO = new AlunosBO();
$aluno = $alunosBO->retornaPorCodigo(8);
session_start();
$_SESSION["aluno"] = serialize($aluno);/**/

$aluno = $autenticacaoBO->verificarAluno();

if($_POST) {
}

$tpl_main = $templateBO->carregarPaginaAluno($aluno);

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('aluno.tpl');

$templateBO->iniciarAluno($tpl);


$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>