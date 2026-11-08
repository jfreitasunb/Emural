<?php
require_once 'conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
seg_proteger();

require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';

require_once 'HTML/Template/Sigma.php';

$semestresBO = new SemestresBO();

$semestre = $semestresBO->retornaUltimoSemestre();

$mensagem = array();
$dados = null;

if($_POST) {
	$dados = new stdClass();
	//$dados->matricula = $_POST['matricula'];
	$email_temp = str_replace(' ', '', $_POST['email']);
	$email_temp = strtolower($email_temp);
	$email_confirmar_temp = str_replace(' ', '', $_POST['email_confirmar']);
	$email_confirmar_temp = strtolower($email_confirmar_temp);
	$dados->matricula = preg_replace("/[^0-9 ]/", '', $_POST['matricula']);
	$dados->email = trim($email_temp);
	$dados->email_confirmar = trim($email_confirmar_temp);
	$dados->senha = $_POST['senha'];
	$dados->confirmar_senha = $_POST['confirmar_senha'];

	foreach($dados as $id => $dado) {
		if (!strlen($dado)) {
			$mensagem[] = $id." não pode ficar vazio.";
		}
	}

	$dados->disciplina = $_POST['disciplina'];
	if ($dados->disciplina == 0) {
		$mensagem[] = "disciplina não pode ficar vazio.";
	}

	$dados->turma = $_POST['turma'];
	if ($dados->turma == 0) {
		$mensagem[] = "turma não pode ficar vazio.";
	}

	if (!filter_var($dados->email, FILTER_VALIDATE_EMAIL)) {
		$mensagem[] = "e-mail inválido.";
	}

	if (!filter_var($dados->email_confirmar, FILTER_VALIDATE_EMAIL)) {
		$mensagem[] = "e-mail inválido.";
	}

	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $dados->senha);
	$lowercase = preg_match('@[a-z]@', $dados->senha);
	$number    = preg_match('@[0-9]@', $dados->senha);
	$specialChars = preg_match('@[^\w]@', $dados->senha);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($dados->senha) < 8) {
    	$mensagem[] = "Sua tenha deve conter pelo menos 8 caracteres, sendo pelo menos 1 lestra maiúscula, 1 letra minúscula, 1 número e 1 caracter especial.";
	}

	if (strcmp($dados->email, $dados->email_confirmar) != 0) {
		$mensagem[] = "O e-mail está diferente de confirmar e-mail.";
	}

	if (strcmp($dados->senha, $dados->confirmar_senha) != 0) {
		$mensagem[] = "Senha está diferente de confirmar senha.";
	}

	if (!count($mensagem)) {
		$pessoasBO = new PessoasBO();
		$composicao_turmasBO = new ComposicaoTurmasBO();
		$aluno = $pessoasBO->retornaPorUsuario($dados->matricula);

		if ($aluno === null || strcmp($aluno->tipo, "aluno") != 0) {
			$mensagem[] = "Matricula ".h($dados->matricula)." não está pre cadastrada.";
		} elseif (strlen($aluno->senha)) {
			// Conta já ativada: a senha só pode ser trocada por quem prova ter
			// acesso ao e-mail cadastrado (fluxo "Esqueci minha senha").
			$mensagem[] = 'Esta matrícula já possui cadastro. Para trocar a senha use a opção <a href="'.h($SITE).'esqueci_senha">Esqueci minha senha</a>.';
		} elseif (!$composicao_turmasBO->estaMatriculado($aluno, $dados->turma)) {
			$mensagem[] = "Turma incorreta.";
		} elseif (strlen($aluno->email)) {
			// E-mail pré-cadastrado e senha ainda não definida: a senha só é definida
			// pelo link enviado para o e-mail já cadastrado.
			if (strcmp($dados->email, strtolower(trim($aluno->email))) == 0) {
				$pessoasBO->esqueciMinhaSenha($aluno);
				$emailBO = new EmailBO();
				$emailBO->enviarEsqueciSenha($aluno, "");
				$mensagem[] = "Enviamos para o seu e-mail um link para você definir sua senha.";
				$dados = null;
			} else {
				$mensagem[] = "Esta matrícula já possui um e-mail cadastrado. Procure o coordenador.";
			}
		} else {
			// Primeiro cadastro: define e-mail e senha; o acesso só é liberado
			// após a confirmação do e-mail.
			if($pessoasBO->mudarEmailPessoa($aluno, $dados->email)) {
				$pessoasBO->mudarSenha($aluno->codigo, $dados->senha);
				$emailBO = new EmailBO();
				$emailBO->enviarValidacao($aluno);
				$mensagem[] = "E-mail e senha cadastrados com sucesso.</br> Verifique a mensagem de confirmação no seu e-mail.";
				$dados = null;
			} elseif (isset($ALERTAS["EJU"])) {
				$mensagem[] = "E-mail já está sendo usado, cadastre outro ou procure o coordenador.";
			}
		}
	}
}
$templateBO = new TemplateBO();

$tpl_main = $templateBO->carregarCabecalhoRodapeMat();

$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('cadastro.tpl');

unset($semestre->codigo);

$disciplinasBO = new DisciplinasBO();
$disciplinasBO->preencheCombo($tpl, $dados);

if ($dados !== null) {
	$tpl->setVariable(array(
		'matricula' => h($dados->matricula),
		'email' => h($dados->email),
		'email_confirmar' => h($dados->email_confirmar)
	));

	if (strlen($dados->disciplina)) {
		$turmasBO = new TurmasBO();
		$turmasBO->preencheComboListaAlunos($tpl, $dados, $semestre);
	}
}

if (count($mensagem)) {
	foreach($mensagem as $aviso) {
		$tpl->setVariable(array(
			'mensagem' => $aviso
		));
		$tpl->parse("adicionar_mensagem");
	}
}

$templateBO->iniciarGenerico($tpl);

$tpl_main->setVariable(array(
	'titulo' => "Cadastro de Aluno",
	'conteudo'  => $tpl->get()
));

$tpl_main->show();
?>
