<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

require_once 'HTML/Template/Sigma.php';

$templateBO = new TemplateBO();
$autenticacaoBO = new AutenticacaoBO();
$pessoasBO = new PessoasBO();

$coordenador = $autenticacaoBO->verificarCoordenador();

if($_POST) {
	$aluno_dados = new stdClass();
	$aluno_dados->matricula = $_POST['matricula'];
	$aluno_dados->nova_senha = $_POST['nova_senha'];
	$aluno_dados->nova_senha_2 = $_POST['nova_senha_2'];

	$pessoasBO->alteraSenhaAlunoPorCoordenador($aluno_dados);
}

$tpl_main = $templateBO->carregarPaginaCoordenadorAlunoSenha();

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('coordenador_aluno_senha.tpl');

$templateBO->iniciarCoordenadorSenha($tpl);

$tpl_main->setVariable(array(
	"conteudo"  => $tpl->get()
));

$templateBO->fechar($tpl_main);
?>