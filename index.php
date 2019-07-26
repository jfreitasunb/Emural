<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/urlBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$pessoasBO = new PessoasBO();
$urlBO = new URLBO();

$autenticacaoBO->redirecionarCasoLogado();

if($_POST) {
	$login = new stdClass();
	$login->usuario = $_POST['usuario'];
	$login->senha = $_POST['senha'];

	$autenticacaoBO->login($login);
} else {
	$login = null;
}

$urlBO->receberAlertas();

$tpl_main = $templateBO->carregarCabecalhoRodapeSomente();


$tpl_pagina = new HTML_Template_Sigma($ROOT_PATH.'template');

$tpl_pagina->loadTemplateFile('login.tpl');

$pessoasBO->preencherObjeto($tpl_pagina,$login);

$templateBO->iniciarLogin($tpl_pagina);

$tpl_main->setVariable(array(
	'conteudo' => $tpl_pagina->get()
));

$templateBO->fechar($tpl_main);

?>
