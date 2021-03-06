<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$pessoasBO = new PessoasBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

if($_POST) {
	$codigo = $_POST['codigo'];
	$email = trim($_POST['email']);

	if($pessoasBO->mudarEmailPessoa($codigo, $email))
	{
		$emailBO = new EmailBO();
		$emailBO->enviarValidacao($codigo);
	}
}

$tpl_main = $templateBO->carregarPaginaCoordenadorAlunoEmail();

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('coordenador_aluno_email.tpl');

$templateBO->iniciarCoordenadorSenha($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>
