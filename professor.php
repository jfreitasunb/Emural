<?php
require_once 'conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
seg_proteger();

require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

require_once 'HTML/Template/Sigma.php';

$turmasBO = new TurmasBO();
$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();

/*require_once $ROOT_PATH.'lib/professoresBO.php';
$professoresBO = new ProfessoresBO();
$professor = $professoresBO->retornaPorCodigo(1);
seg_iniciar_sessao();
$_SESSION["professor"] = serialize($professor);/**/

$professor = $autenticacaoBO->verificarProfessor();

if($_POST) {
}

$semestre = $semestresBO->retornaUltimoSemestre();


$tpl_main = $templateBO->carregarPaginaProfessor($professor,$semestre);


$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');


$tpl->loadTemplateFile('professor.tpl');

$templateBO->iniciarProfessor($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>
