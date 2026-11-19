<?php
require_once 'conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
seg_proteger();

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

$urlBO = new URLBO();
$templateBO = new TemplateBO();
$turmasBO = new TurmasBO();
$responsaveisBO = new ResponsaveisBO();
$monitoresBO = new MonitoresBO();
$avaliacoesBO = new AvaliacoesBO();
$linkBO = new LinkBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();

$url = $urlBO->codigoSegundoTerceiroNivel();

$semestre = $semestresBO->retornaUltimoSemestre();

$turma = $turmasBO->retornaPorCodigoSemestreAtual($url->codigo,$semestre);

$responsavel = $responsaveisBO->retornaPorCodigoETurma($url->codigo2,$turma);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

if($_POST) {
	if (isset($_POST['excluir'])) {
		if ($responsavel !== null) {
			$responsaveisBO->desativar($responsavel);

			$aviso['NOTY_MONES'] = "";

			HTTP::redirect($linkBO->getMonitores($turma,null,$aviso));
			exit;
		}
	} else {
		$avaliacao_id = isset($_POST['avaliacao']) ? $_POST['avaliacao'] : '';
		$monitor_id = isset($_POST['monitor']) ? $_POST['monitor'] : '';

		$avaliacao_obj = ctype_digit((string) $avaliacao_id) ? $avaliacoesBO->retornaPorCodigo($avaliacao_id) : null;
		$monitor_obj = ctype_digit((string) $monitor_id) ? $monitoresBO->retornaPorCodigo($monitor_id) : null;

		// Garante que a avaliação pertence a esta turma e que o monitor existe e está ativo.
		if ($avaliacao_obj !== null
				&& (int) $avaliacao_obj->turma === (int) $turma->codigo
				&& strcmp((string) $avaliacao_obj->status, 't') === 0
				&& $monitor_obj !== null
				&& strcmp((string) $monitor_obj->status, 't') === 0) {
			$valores = new stdClass();
			$valores->avaliacao = (int) $avaliacao_obj->codigo;
			$valores->monitor = (int) $monitor_obj->codigo;
			$valores->lancar = isset($_POST['lancar']) ? 'true' : 'false';
			$valores->editar = isset($_POST['editar']) ? 'true' : 'false';
			$valores->confiar = isset($_POST['confiar']) ? 'true' : 'false';

			$responsaveisBO->inserirAtualizar($valores,$responsavel);

			$responsavel = $responsaveisBO->retornaPorCodigoETurma($url->codigo2,$turma);
		}
	}
}

$tpl_main = $templateBO->carregarPaginaMonitores($professor,$semestre,$turma);

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
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