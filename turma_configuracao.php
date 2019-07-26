<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';

require_once 'HTML/Template/Sigma.php';

$urlBO = new URLBO();
$turmasBO = new TurmasBO();
$templateBO = new TemplateBO();
$avaliacoesBO = new AvaliacoesBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();
$linkBO = new LinkBO();

$url = $urlBO->codigoSegundoNivel();

$turma = $turmasBO->retornaPorCodigo($url->codigo);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

if($_POST) {
	if(isset($_POST["avaliacoes_anteriores"]) && strlen($_POST["avaliacoes_anteriores"])) {
		$manter_avaliacoes = true;
	} else {
		$manter_avaliacoes = false;
		$turmasBO->removerAvaliacoes($turma);
	}

	switch ($_POST["tipo_media"]) {
		case "simples";
			foreach($_POST as $key => $value)
			{
				if(strpos($key, "quantidade_") !== false) {
					$avaliacoes[substr($key,11)] = $value;
				}
			}
			$pesos = $avaliacoesBO->inserirAvaliacoesQuantidade($turma,$avaliacoes,$manter_avaliacoes);
			//print_r($pesos);
			$turmasBO->atualizarCalculoMediaPonderada($pesos,$turma);
			break;
		case "ponderada":
			foreach($_POST as $key => $value)
			{
				if(strpos($key, "peso_") !== false) {
					$pesos[substr($key,5)] = $value;
				}
			}
			$pesos = $avaliacoesBO->inserirMediaPonderada($turma,$pesos,$manter_avaliacoes);
			//print_r($pesos);
			$turmasBO->atualizarCalculoMediaPonderada($pesos,$turma);
			break;
		case "personalizada":
			echo "personalizada";
			break;
		case "rapida":
			$data['Prova_1'] = $_POST['data_prova_1'];
			$data['Prova_2'] = $_POST['data_prova_2'];
			$data['Prova_3'] = $_POST['data_prova_3'];
			$pesos = $avaliacoesBO->inserirAvaliacoesRapido($turma,$data,$manter_avaliacoes);
			//print_r($pesos);
			$turmasBO->atualizarCalculoMediaPonderada($pesos,$turma);
			break;
		default:
			break;
	}
	if(strlen($turma->compisicao_nota)) {
		$ALERTAS["TRS"]->link = $linkBO->getTurma($turma);
	} else {
		$ALERTAS["TCS"]->link = $linkBO->getProfessor();
	}
}

$semestre = $semestresBO->retornaUltimoSemestre();

$tpl_main = $templateBO->carregarPaginaConfiguracaoTurma($professor,$semestre,$turma);

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');

$tpl->loadTemplateFile('turma_configuracao.tpl');
$turmasBO->preencherObjeto($tpl,$turma,"turma_");

$semestresBO->preencheDatasConfiguracaoRapida($tpl,$semestre);

$templateBO->iniciarTurmaConfiguracoes($tpl,$turma);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>