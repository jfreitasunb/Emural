<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$linkBO = new LinkBO();
$pessoasBO = new PessoasBO();

$aluno = $autenticacaoBO->verificarAluno(FALSE);

if($_POST) {
	if($pessoasBO->mudarEmailPessoa($aluno, $_POST['email']))
	{
		$emailBO = new EmailBO();
		$emailBO->enviarValidacao($aluno);
	}
}

if (strcmp($aluno->email_valido,'t') == 0) {
	$tpl_main = $templateBO->carregarPaginaAlunoEmail($aluno, true);
} else {
	$tpl_main = $templateBO->carregarPaginaAlunoEmail($aluno, false);
}

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('aluno_email.tpl');

$pessoasBO->preenchePaginaEmail($tpl, $aluno);

$templateBO->iniciarAlunoEmail($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>