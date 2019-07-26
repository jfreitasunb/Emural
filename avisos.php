<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/observacoesBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

require_once 'HTML/Template/Sigma.php';
require_once 'HTTP.php';

$urlBO = & new URLBO();
$templateBO = & new TemplateBO();
$turmasBO = & new TurmasBO();
$observacoesBO = & new ObservacoesBO();
$linkBO = & new LinkBO();
$autenticacaoBO = & new AutenticacaoBO();
$semestresBO = & new SemestresBO();

$url = & $urlBO->codigoSegundoTerceiroNivel();

$semestre = & $semestresBO->retornaUltimoSemestre();

$turma = & $turmasBO->retornaPorCodigoSemestreAtual($url->codigo,$semestre);

$observacao = & $observacoesBO->retornaPorCodigoETurma($url->codigo2,$turma);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

if($_POST) {
	$valores->titulo = $_POST['titulo'];
	$valores->descricao = $_POST['descricao'];
	$valores->data_divulgacao = $_POST['data_divulgacao'];
	$valores->turma = $turma->codigo;
	$valores->valido = "true";

	$observacoesBO->inserirAtualizar($valores,$observacao);

	$observacao = & $observacoesBO->retornaPorCodigoETurma($url->codigo2,$turma);
} else if (isset($_GET["d"])) {
	$observacoesBO->desativar($observacao);

	$aviso['NOTY_AVIES'] = "";
	HTTP::redirect($linkBO->getAvisos($turma,null,$aviso));
}

$tpl_main = $templateBO->carregarPaginaAvisos($professor,$semestre,$turma);

$tpl = & new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('avisos.tpl');


$turmasBO->preencherObjeto($tpl,$turma,"turma_");
$observacoesBO->preencherObjeto($tpl,$observacao,"observacao_ativa_");

$observacoesBO->preencheValidas($tpl,$turma,$observacao);

$templateBO->iniciarAvisos($tpl,$turma,$observacao);


$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>