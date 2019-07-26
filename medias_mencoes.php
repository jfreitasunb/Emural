<?php
require_once 'conf/default.php';
require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

require_once 'HTML/Template/Sigma.php';

$urlBO = & new URLBO();
$templateBO = & new TemplateBO();
$avaliacoesBO = & new AvaliacoesBO();
$turmasBO = & new TurmasBO();
$notasBO = & new NotasBO();
$composicaoTurmasBO = & new ComposicaoTurmasBO();
$autenticacaoBO = & new AutenticacaoBO();
$semestresBO = & new SemestresBO();

$url = & $urlBO->codigoSegundoNivel();

$semestre = & $semestresBO->retornaUltimoSemestre();

$turma = & $turmasBO->retornaPorCodigoSemestreAtual($url->codigo,$semestre);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

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

	if(isset($_POST["exibir_medias"])) {
		$turma_alterar['exibe_media'] = 'true';
	} else {
		$turma_alterar['exibe_media'] = 'false';
	}

	if(isset($_POST["exibir_mencoes"])) {
		$turma_alterar['exibe_mencao'] = 'true';
	} else {
		$turma_alterar['exibe_mencao'] = 'false';
	}

	$turmasBO->atualizarExibirMediaMencao($turma,$turma_alterar);

	$turma = & $turmasBO->retornaPorCodigo($url->codigo);

	$ALERTAS["MMFAS"] = "";
}

$tpl_main = $templateBO->carregarPaginaMediasMencoes($professor,$semestre,$turma);

$tpl_pagina = & new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl_pagina->loadTemplateFile('medias_mencoes.tpl');

$turmasBO->preencherObjeto($tpl_pagina,$turma,"turma_");

$turmasBO->preencherExibirMediaMencao($tpl_pagina,$turma);

$avaliacoesBO->preencheCheckAvaliacoes($tpl_pagina,$turma,true);

$tpl_tabela = & new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl_tabela->loadTemplateFile('tabela.tpl');

$avaliacoesBO->preencheTabelaAvaliacoes($tpl_tabela,$turma,null,"medias_mencoes");

$templateBO->iniciarTabela($tpl_tabela);

$tpl_pagina->setVariable(array(
	"tabela_notas"  => $tpl_tabela->get()
));

$templateBO->iniciarMediasMencoes($tpl_pagina);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);
?>