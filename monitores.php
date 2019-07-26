<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/responsaveisBO.php';
require_once $ROOT_PATH.'lib/monitoresBO.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

require_once 'HTML/Template/Sigma.php';

$urlBO = & new URLBO();
$templateBO = & new TemplateBO();
$turmasBO = & new TurmasBO();
$responsaveisBO = & new ResponsaveisBO();
$monitoresBO = & new MonitoresBO();
$avaliacoesBO = & new AvaliacoesBO();
$linkBO = & new LinkBO();
$autenticacaoBO = & new AutenticacaoBO();
$semestresBO = & new SemestresBO();

$url = & $urlBO->codigoSegundoTerceiroNivel();

$semestre = & $semestresBO->retornaUltimoSemestre();

$turma = & $turmasBO->retornaPorCodigoSemestreAtual($url->codigo,$semestre);

$responsavel = & $responsaveisBO->retornaPorCodigoETurma($url->codigo2,$turma);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

if($_POST) {
	$valores->avaliacao = $_POST['avaliacao'];
	$valores->monitor = $_POST['monitor'];
	if(isset($_POST['lancar']))
		$valores->lancar = $_POST['lancar'];
	if(isset($_POST['editar']))
		$valores->editar = $_POST['editar'];
	if(isset($_POST['confiar']))
		$valores->confiar = $_POST['confiar'];

	$responsaveisBO->inserirAtualizar($valores,$responsavel);

	$responsavel = & $responsaveisBO->retornaPorCodigoETurma($url->codigo2,$turma);
} if ($url->deletar) {
	$responsaveisBO->desativar($responsavel);

	$aviso['NOTY_MONES'] = "";

	HTTP::redirect($linkBO->getMonitores($turma,null,$aviso));
}

$tpl_main = $templateBO->carregarPaginaMonitores($professor,$semestre,$turma);

$tpl = & new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('monitores.tpl');


$turmasBO->preencherObjeto($tpl,$turma,"turma_");
$monitoresBO->preencheCombo($tpl,$responsavel);
$avaliacoesBO->preencheCombo($tpl,$turma,$responsavel);

$responsaveisBO->preencherMonitores($tpl,$turma,$responsavel);

$templateBO->iniciarMonitores($tpl,$turma,$responsavel);


$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>