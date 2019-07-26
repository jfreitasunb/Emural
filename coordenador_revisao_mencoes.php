<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';

require_once 'HTML/Template/Sigma.php';

$urlBO = new URLBO();
$turmasBO = new TurmasBO();
$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();
$avaliacoesBO = new AvaliacoesBO();
$composicaoTurmasBO = new ComposicaoTurmasBO();

$url = $urlBO->codigoSegundoNivel();

$semestre = & $semestresBO->retornaUltimoSemestre();

$turma = & $turmasBO->retornaPorCodigoExcetoSemestreAtual($url->codigo, $semestre);

$coordenador = $autenticacaoBO->verificarCoordenador();

if($_POST) {
	foreach ($_POST as $key => $value)
	{
		if(strpos($key, "mencao_") !== false) {
			$atualizar[substr($key,7)]->mencao = $_POST["mencao_".substr($key,7)];
			$atualizar[substr($key,7)]->media = $_POST["media_".substr($key,7)];
			$atualizar[substr($key,7)]->faltas = $_POST["faltas_".substr($key,7)];
		}
	}
	//print_r($atualizar);
	$composicaoTurmasBO->atualizaMediaMencaoFaltas($atualizar,$turma);

	$ALERTAS["MMFAS"] = "";
}

$tpl_main = $templateBO->carregarPaginaCoordenadorRevisaoMencoes();

$tpl_pagina = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl_pagina->loadTemplateFile('coordenador_revisao_mencoes.tpl');

$turmasBO->preencherObjeto($tpl_pagina,$turma,"turma_");
$turmasBO->preencheComboMesmoSemestre($tpl_pagina,$turma);
$semestresBO->preencheComboAnoSemestreExcetoAtual($tpl_pagina,$turma);

if($turma !== null) {
	$tpl_tabela = new HTML_Template_Sigma($ROOT_PATH.'template');
	$tpl_tabela->loadTemplateFile('tabela.tpl');

	$avaliacoesBO->preencheTabelaAvaliacoes($tpl_tabela,$turma,null,"medias_mencoes");

	$templateBO->iniciarTabela($tpl_tabela);

	$tpl_pagina->setVariable(array(
		"tabela_notas"  => $tpl_tabela->get()
	));
}

$templateBO->iniciarCoordenadorRevisaoMencoes($tpl_pagina);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);
?>