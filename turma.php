<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';
require_once $ROOT_PATH.'lib/log_responsaveisBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

require_once 'HTML/Template/Sigma.php';

$urlBO = new URLBO();
$turmasBO = new TurmasBO();
$templateBO = new TemplateBO();
$avaliacoesBO = new AvaliacoesBO();
$notasBO = new NotasBO();
$logResponsaveisBO = new LogResponsaveisBO();
$autenticacaoBO = new AutenticacaoBO();
$semestresBO = new SemestresBO();

$url = $urlBO->codigoSegundoNivel();

$semestre = $semestresBO->retornaUltimoSemestre();

$turma = $turmasBO->retornaPorCodigoSemestreAtual($url->codigo,$semestre);

$professor = $autenticacaoBO->verificarProfessor($turma->professor);

if($_POST) {
}

$tpl_main = $templateBO->carregarPaginaTurma($professor,$semestre,$turma);

$tpl_pagina = new HTML_Template_Sigma($ROOT_PATH.'template');


$tpl_pagina->loadTemplateFile('turma.tpl');
$turmasBO->preencherObjeto($tpl_pagina,$turma,"turma_");

$notasBO->preencheGraficoNotasTurma($tpl_pagina,$turma);
$logResponsaveisBO->preenchePaginaTurma($tpl_pagina,$turma);
$avaliacoesBO->preencheCheckAvaliacoes($tpl_pagina,$turma);

$tpl_tabela = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl_tabela->loadTemplateFile('tabela.tpl');

$avaliacoesBO->preencheTabelaAvaliacoes($tpl_tabela,$turma,null,"medias_mencoes_sl");
$templateBO->iniciarTabela($tpl_tabela);

$tpl_pagina->setVariable(array(
	"tabela_notas"  => $tpl_tabela->get()
));

$templateBO->iniciarTurma($tpl_pagina,$turma);


$tpl_main->setVariable(array(
	"conteudo"  => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);
?>