<?php
require_once 'conf/default.php';

require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';

require_once 'HTML/Template/Sigma.php';

$semestresBO = & new SemestresBO();

$semestre = & $semestresBO->retornaUltimoSemestre();

$mensagem = array();
$dados = null;

if($_POST) {
	$dados = & new stdClass();
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


	if (!count($mensagem)) {
		if (strcmp($dados->senha, $dados->confirmar_senha) == 0) {
			$pessoasBO = & new PessoasBO();
			$aluno = $pessoasBO->retornaPorUsuario($dados->matricula);

			if ($aluno !== null) {
				if (!strlen($aluno->senha) && !strlen($aluno->email)) {
					$composicao_turmasBO = & new ComposicaoTurmasBO();
					if ($composicao_turmasBO->estaMatriculado($aluno, $dados->turma)) {
						if($pessoasBO->mudarEmailPessoa($aluno, $dados->email)) {
							$pessoasBO->mudarSenha($aluno->codigo, $dados->senha);
							$emailBO = & new EmailBO();
							$emailBO->enviarValidacao($aluno);
							$mensagem[] = "E-mail e senha cadastrados com sucesso.</br> Verifique a mensagem de confirmação no seu e-mail.";
							$dados = null;
						} elseif (isset($ALERTAS["EJU"])) {
							$mensagem[] = "E-mail já está sendo usado, cadastre outro ou procure o coordenador.";
						}
					} else {
						$mensagem[] = "Turma incorreta.";
					}
				} else {
					$mensagem[] = "Aluno com matricula ".$dados->matricula." já possui senha e/ou e-mail cadastrado(a).";
					$mensagem[] = "Entre em contato com seu professor.";
				}
			} else {
				$mensagem[] = "Matricula ".$dados->matricula." não está pre cadastrada.";
			}
		} else {
			$mensagem[] = "Senha está diferente de confirmar senha.";
		}

		if (!strcmp($dados->email, $dados->email_confirmar) == 0){
			$mensagem[] = "O e-mail está diferente de confirmar e-mail.";
		}
	}
}
$templateBO = & new TemplateBO();

$tpl_main = & $templateBO->carregarCabecalhoRodapeMat();

$tpl = & new HTML_Template_Sigma($ROOT_PATH.'template');
$tpl->loadTemplateFile('cadastro.tpl');

unset($semestre->codigo);

$disciplinasBO = & new DisciplinasBO();
$disciplinasBO->preencheCombo($tpl, $dados);

if ($dados !== null) {
	$tpl->setVariable(array(
		'matricula' => $dados->matricula,
		'email' => $dados->email,
		'email_confirmar' => $dados->email_confirmar
	));

	if (strlen($dados->disciplina)) {
		$turmasBO = & new TurmasBO();
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
