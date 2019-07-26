<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = & new TemplateBO();
$autenticacaoBO = & new AutenticacaoBO();
$semestresBO = & new SemestresBO();
$disciplinasBO = & new DisciplinasBO();
$turmasBO = & new TurmasBO();
$linkBO = & new LinkBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

$tpl_main = $templateBO->carregarPaginaRelatorioCoordenadorPorcentagemMencoes();

$tpl_pagina = & new HTML_Template_Sigma($ROOT_PATH.'template/relatorios');
$tpl_pagina->loadTemplateFile('coordenador_reprovados_disciplina.tpl');

if($_POST) {
	$dados->disciplina = $_POST['disciplina'];

	$disciplina = & $disciplinasBO->retornaPorCodigo($dados->disciplina);
	$semestre = & $semestresBO->retornaUltimoSemestre();

	$tpl_tabela = & new HTML_Template_Sigma($ROOT_PATH.'template');
	$tpl_tabela->loadTemplateFile('tabela_com_titulo.tpl');

	$preencheu = $turmasBO->preencheTabelaRelatorioReprovadosDisciplina($tpl_tabela,$dados,$semestre);

	if($preencheu) {
		$tpl_pagina->setVariable(array(
			'relatorio_disciplina_descricao'  => $disciplina->descricao,
			'relatorio_disciplina_codigo' => $disciplina->codigo,

			'link_relatorio_coordenador_lista_alunos_csv' => $linkBO->getCoordenadorRelatorioListaAlunosCSV()
		));

		$templateBO->iniciarTabela($tpl_tabela);

		$tpl_pagina->setVariable(array(
			"relatorio"  => $tpl_tabela->get()
		));
	} else {
		$tpl_pagina->setVariable(array(
			"sem_dados"  => "Não existem dados para essa disciplina."
		));
	}
} else {
	$dados = null;
	$semestre = null;
}
$disciplinasBO->preencheCombo($tpl_pagina,$dados);

$templateBO->iniciarCoordenadorRelatorioPorcentagemMencoes($tpl_pagina);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);
?>