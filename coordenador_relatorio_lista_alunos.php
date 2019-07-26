<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();
$disciplinasBO = new DisciplinasBO();
$turmasBO = new TurmasBO();
$composicaoTurmasBO = new ComposicaoTurmasBO();
$linkBO = new LinkBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

$tpl_main = $templateBO->carregarPaginaRelatorioCoordenadorPorcentagemMencoes();

$tpl_pagina = new HTML_Template_Sigma($ROOT_PATH.'template/relatorios');
$tpl_pagina->loadTemplateFile('coordenador_lista_alunos.tpl');

if($_POST) {
	$dados->semestre = $_POST['ano_semestre'];
	$dados->disciplina = $_POST['disciplina'];
	if(isset($_POST['turma']) && $_POST['turma'] != 0)
		$dados->turma = $_POST['turma'];
	else
		$dados->turma = null;

	if(isset($_POST['aprovados'])) {
		$dados->apenas_aprovados = true;

		$tpl_pagina->setVariable(array(
			'aprovados_checked'  => 'checked="checked"'
		));
	} else
		$dados->apenas_aprovados = false;

	$semestre = $semestresBO->retornaPorCodigo($dados->semestre);
	$disciplina = $disciplinasBO->retornaPorCodigo($dados->disciplina);
	$turma = $turmasBO->retornaPorCodigo($dados->turma);

	$tpl_tabela = new HTML_Template_Sigma($ROOT_PATH.'template');
	$tpl_tabela->loadTemplateFile('tabela_com_titulo.tpl');

	$preencheu = $turmasBO->preencheTabelaRelatorioListaAlunos($tpl_tabela,$dados,$semestre);

	if($preencheu) {
		if($dados->apenas_aprovados) {
			$tpl_pagina->setVariable(array(
				'relatorio_aprovados'  => "true"
			));
		}

		if($turma != null) {
			$tpl_pagina->setVariable(array(
				'relatorio_turma_descricao'  => $turma->descricao,
				'relatorio_turma_codigo'  => $turma->codigo,
			));
		}

		$tpl_pagina->setVariable(array(
			'relatorio_disciplina_descricao'  => $disciplina->descricao,
			'relatorio_ano_semestre'  => $semestre->ano."/".$semestre->semestre,
			'relatorio_disciplina_codigo' => $disciplina->codigo,
			'relatorio_ano_semestre_codigo' => $semestre->codigo,

			'link_relatorio_coordenador_lista_alunos_csv' => $linkBO->getCoordenadorRelatorioListaAlunosCSV()
		));

		$templateBO->iniciarTabela($tpl_tabela);

		$tpl_pagina->setVariable(array(
			"relatorio"  => $tpl_tabela->get()
		));
	} else {
		
	}
} else {
	$dados = null;
	$semestre = null;
}
$semestresBO->preencheComboAnoSemestreExcetoAtualRelatorioListaAlunos($tpl_pagina,$dados);
$disciplinasBO->preencheCombo($tpl_pagina,$dados);
$turmasBO->preencheComboListaAlunos($tpl_pagina,$dados,$semestre);

$templateBO->iniciarCoordenadorRelatorioPorcentagemMencoes($tpl_pagina);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);
?>