<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

require_once 'HTML/Template/Sigma.php';

$urlBO = new URLBO();
$templateBO = new TemplateBO();
$avaliacoesBO = new AvaliacoesBO();
$turmasBO = new TurmasBO();
$notasBO = new NotasBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();

$url = $urlBO->codigoSegundoNivel();
$avaliacao = $avaliacoesBO->retornaPorCodigo($url->codigo);

$semestre = $semestresBO->retornaUltimoSemestre();

$turma = $turmasBO->retornaPorCodigoSemestreAtual($avaliacao->turma,$semestre);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

if($_POST) {
	/*$notas = null;
	foreach($_POST as $key => $value)
	{
		if(strpos($key, "codigo_") !== false) {
			$codigo = substr($key,7);
			$notas->$codigo->aluno_codigo = $codigo;
			$notas->$codigo->nota = $value;
			$notas->$codigo->observacao = $_POST["obs_".$codigo];
		}
	}
	if($notas !== null) {
		$notasBO->inserir($avaliacao,$notas);
	}*/
	
	$notas = array();
	foreach($_POST as $key => $value)
	{
		if(strpos($key, "codigo_") !== false) {
			$codigo = substr($key,7);

			$obj->aluno_codigo = $codigo;
			$obj->nota = $value;
			$obj->observacao = $_POST["obs_".$codigo];

			$notas[$codigo] = $obj;

			unset($obj);
		}
	}

	if(count($notas) > 0) {
		$notasBO->inserir($avaliacao,$notas);
	}

	$avaliacao_atualizar->data_realizacao = $_POST["data_realizacao"];
	$avaliacao_atualizar->data_divulgacao = $_POST["data_divulgacao"];
	if(isset($_POST["divulgacao"])) {
		$avaliacao_atualizar->divulgacao = "true";
	} else {
		$avaliacao_atualizar->divulgacao = "false";
	}

	$avaliacoesBO->atualizarDatas($avaliacao,$avaliacao_atualizar);

	$avaliacao = $avaliacoesBO->retornaPorCodigo($url->codigo);
	//print_r($notas);
	$ALERTAS["AVASS"] = "";
}

$tpl_main = $templateBO->carregarPaginaAvaliacao($professor,$semestre,$turma,$avaliacao);

$tpl_pagina = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl_pagina->loadTemplateFile('avaliacao.tpl');


$avaliacoesBO->preenchePaginaAvaliacao($tpl_pagina,$turma,$avaliacao);
$turmasBO->preencherObjeto($tpl_pagina,$turma,"turma_");

$tpl_tabela = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl_tabela->loadTemplateFile('tabela.tpl');

$avaliacoesBO->preencheTabelaAvaliacoes($tpl_tabela,$turma,$avaliacao,"avaliacao");

$templateBO->iniciarTabela($tpl_tabela);

$tpl_pagina->setVariable(array(
	"tabela_notas"  => $tpl_tabela->get()
));

$templateBO->iniciarAvaliacao($tpl_pagina);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);
?>