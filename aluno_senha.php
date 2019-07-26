<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = & new TemplateBO();
$autenticacaoBO = & new AutenticacaoBO();
$linkBO = & new LinkBO();
$pessoasBO = & new PessoasBO();

$aluno = $autenticacaoBO->verificarAluno();

if($_POST) {
	$pessoasBO->mudarSenhaPessoa($_POST,$aluno);

	$aluno = $pessoasBO->retornaPorCodigo($aluno->codigo);

	$autenticacaoBO->recarregaPessoa($aluno,"aluno");;
}

$tpl_main = $templateBO->carregarPaginaAlunoSenha($aluno);

$tpl = & new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('coordenador_senha.tpl');

$templateBO->iniciarCoordenadorSenha($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>