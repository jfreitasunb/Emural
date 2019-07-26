<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$linkBO = new LinkBO();
$pessoasBO = new PessoasBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

if($_POST) {
	$pessoasBO->mudarSenhaPessoa($_POST,$coordenador);

	$coordenador = $pessoasBO->retornaPorCodigo($coordenador->codigo);

	$autenticacaoBO->recarregaPessoa($coordenador,"coordenador");
}

$tpl_main = $templateBO->carregarPaginaCoordenadorSenha();

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('coordenador_senha.tpl');

$templateBO->iniciarCoordenadorSenha($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>