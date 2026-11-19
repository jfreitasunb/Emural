<?php
require_once 'conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
seg_proteger();

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
	$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';

	$aluno = ctype_digit((string) $codigo) ? $pessoasBO->retornaPorCodigo($codigo) : null;

	// Permite alterar apenas contas do tipo aluno.
	if($aluno !== null && strcmp($aluno->tipo, 'aluno') === 0 && $pessoasBO->mudarEmailPessoa($aluno, $email))
	{
		$emailBO = new EmailBO();
		$emailBO->enviarValidacao($aluno);
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
