<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';
require_once $ROOT_PATH.'lib/alunosBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();
$disciplinasBO = new DisciplinasBO();
$alunosBO = new AlunosBO();
$composicaoTurmasBO = new ComposicaoTurmasBO();
$linkBO = new LinkBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

$tpl_main = $templateBO->carregarPaginaRelatorioCoordenadorPorcentagemMencoes();

$tpl_pagina = new HTML_Template_Sigma($ROOT_PATH.'template/relatorios');
$tpl_pagina->loadTemplateFile('coordenador_porcentagem_mencoes.tpl');

if($_POST) {
	$dados->inicio = $_POST['ano_semestre_inicio'];
	$dados->fim = $_POST['ano_semestre_fim'];
	$dados->disciplina = $_POST['disciplina'];
	$dados->opcao_curso = $_POST['opcao_curso'];

	$tpl_tabela = new HTML_Template_Sigma($ROOT_PATH.'template');
	$tpl_tabela->loadTemplateFile('tabela_relatorios.tpl');
	
	$semestre_inicio = & $semestresBO->retornaPorCodigo($dados->inicio);
	$semestre_fim = & $semestresBO->retornaPorCodigo($dados->fim);
	$disciplina = & $disciplinasBO->retornaPorCodigo($dados->disciplina);

	$preencheu = $composicaoTurmasBO->preencheTabelaRelatorioPorcentagemMencoes($tpl_tabela,$dados,$semestre_inicio,$semestre_fim);

	if($preencheu) {
		$tpl_pagina->setVariable(array(
			'relatorio_inicio_ano_semestre'  => $semestre_inicio->ano."/".$semestre_inicio->semestre,
			'relatorio_fim_ano_semestre'  => $semestre_fim->ano."/".$semestre_fim->semestre,
			'relatorio_disciplina_descricao'  => $disciplina->descricao,
			'relatorio_opcao_curso'  => $dados->opcao_curso,
			'relatorio_ano_semestre_inicio_codigo' => $semestre_inicio->codigo,
			'relatorio_ano_semestre_fim_codigo' => $semestre_fim->codigo,
			'relatorio_disciplina_codigo' => $disciplina->codigo,
			'link_relatorio_coordenador_porcentagem_mencoes' => $linkBO->getCoordenadorRelatorioPorcentagemMencoesCSV()
		));

		$templateBO->iniciarTabela($tpl_tabela);

		$tpl_pagina->setVariable(array(
			"relatorio"  => $tpl_tabela->get()
		));
	} else {
		
	}
} else {
	$dados = null;
}

$semestresBO->preencheComboAnoSemestreExcetoAtualRelatorioPorcentagemMencoes($tpl_pagina,$dados);
$disciplinasBO->preencheCombo($tpl_pagina,$dados);
$alunosBO->preencheComboOpcaoDeCurso($tpl_pagina,$dados);

$templateBO->iniciarCoordenadorRelatorioPorcentagemMencoes($tpl_pagina);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);
?>