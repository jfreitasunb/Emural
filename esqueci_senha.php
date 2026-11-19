<?php
require_once 'conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
seg_proteger();

require_once $ROOT_PATH.'lib/urlBO.php';
require_once $ROOT_PATH.'lib/templateBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/emailBO.php';
require_once $ROOT_PATH.'lib/alertasBO.php';

require_once $ROOT_PATH.'lib/linkBO.php';

$urlBO = new URLBO();
$url = $urlBO->informacoesGet();

$templateBO = new TemplateBO();

$dados = null;


if ($_GET && isset($_GET['esqueci']) && strlen($_GET['esqueci'])) {
	$hast_esqueci = $_GET['esqueci'];


	$pessoasBO =  new PessoasBO();
	$pessoa = $pessoasBO->retornaPorHastEsqueciSenha($hast_esqueci);

	$linkBO = new LinkBO();
	if ($pessoa === null || strcmp($pessoa->tipo, "aluno") !== 0) {
		HTTP::redirect($linkBO->getEsqueciSenha());
		exit();
	}

	if ($_POST) {
		$dados = new stdClass();
		$dados->senha = isset($_POST['senha']) ? (string) $_POST['senha'] : '';
		$dados->confirmar_senha = isset($_POST['confirmar_senha']) ? (string) $_POST['confirmar_senha'] : '';

		if (!strlen($dados->senha)) {
			$ALERTAS['ESSV'] = "";
		}
		if (!strlen($dados->confirmar_senha)) {
			$ALERTAS['ESCSV'] = "";
		}

		if (!seg_validar_senha_forte($dados->senha)) {
	    	$ALERTAS['STMCE'] = "";
		}

		if (!count($ALERTAS)) {
			if ($dados->senha === $dados->confirmar_senha) {
				$pessoasBO->mudarSenhaEsqueciSenha($pessoa, $dados->senha);

				if (isset($url->moodle)) {
					HTTP::redirect($linkBO->getMoodle());
					exit();
				} else {
					HTTP::redirect($linkBO->getIndex());
					exit();
				}
			} else {
				$ALERTAS['ESSD'] = "";
			}
		}
	}

	$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
	$tpl->loadTemplateFile('mudar_senha.tpl');

	$tpl->setVariable(array(
		'nome' => h($pessoa->nome),
		'matricula' => h($pessoa->usuario)
	));

	if (isset($url->moodle)) {
		$tpl_main = $templateBO->carregarCabecalhoRodapeMat();

		if (count($ALERTAS)) {
			$alertasBO = new AlertasBO();
			$alertas = $alertasBO->getAlertas();

			foreach($ALERTAS as $aviso => $nada) {
				$tpl->setVariable(array(
					'mensagem' => $alertas[$aviso]['mensagem']
				));
				$tpl->parse("adicionar_mensagem");
			}
		}
	} else {
		$tpl_main = $templateBO->carregarCabecalhoRodapeSomente();

		$tpl_main->setVariable(array(
			'conteudo_topo'  => '<link rel="stylesheet" href="'.$ROOT.'css/mudar_senha_emural.css" type="text/css" />'
		));
		$tpl_main->parse("adicionar_conteudo_topo");

		$alertasBO = new AlertasBO();
		$alertasBO->preencheAlertas($tpl_main);
	}

	$templateBO->iniciarGenerico($tpl);

	$tpl_main->setVariable(array(
		'titulo' => "Alterar Minha Senha",
		'conteudo'  => $tpl->get()
	));
	$tpl_main->show();
} else {
	if ($_POST) {
		$dados = new stdClass();
		$dados->matricula = preg_replace("/[^0-9 ]/", '', isset($_POST['matricula']) ? (string) $_POST['matricula'] : '');
		$dados->email = trim(isset($_POST['email']) ? (string) $_POST['email'] : '');

		$ip = seg_ip_cliente();
		if (seg_limite_excedido('esqueci_ip', $ip, 10, SEG_LOGIN_JANELA_SEGUNDOS)
				|| (strlen($dados->matricula) && seg_limite_excedido('esqueci_mat', $ip.'|'.$dados->matricula, 3, SEG_LOGIN_JANELA_SEGUNDOS))) {
			$ALERTAS['ESBLQ'] = "";
		} else {
			seg_limite_registrar('esqueci_ip', $ip, SEG_LOGIN_JANELA_SEGUNDOS);
			if (strlen($dados->matricula)) {
				seg_limite_registrar('esqueci_mat', $ip.'|'.$dados->matricula, SEG_LOGIN_JANELA_SEGUNDOS);
			}

			if (!strlen($dados->matricula)) {
				$ALERTAS['ESMV'] = "";
			}
			if (!strlen($dados->email)) {
				$ALERTAS['ESEV'] = "";
			}

			$pessoasBO = new PessoasBO();
			$pessoa = $pessoasBO->retornaPorUsuario($dados->matricula);

			if (!count($ALERTAS)) {
				if ($pessoa !== null && strcmp($pessoa->tipo, "aluno") == 0
						&& strcmp(strtolower(trim((string) $pessoa->email)), strtolower($dados->email)) == 0) {
					$pessoasBO->esqueciMinhaSenha($pessoa);

					$tipo = "";
					if (isset($url->moodle)) {
						$tipo = "moodle";
					}

					$emailBO = new EmailBO();
					$emailBO->enviarEsqueciSenha($pessoa, $tipo);
					$ALERTAS['ESEEMS'] = "";
					$dados = null;
				} else {
					$ALERTAS['ESMENC'] = "";
				}
			}
		}
	}

	$tpl = new HTML_Template_Sigma($ROOT_PATH.'template');
	$tpl->loadTemplateFile('esqueci_senha.tpl');

	if ($dados !== null) {
		$tpl->setVariable(array(
			'matricula' => h($dados->matricula),
			'email' => h($dados->email)
		));
	}

	$tpl_main = null;

	if (isset($url->moodle)) {
		$tpl_main = $templateBO->carregarCabecalhoRodapeMat();

		if (count($ALERTAS)) {
			$alertasBO = new AlertasBO();
			$alertas = $alertasBO->getAlertas();

			foreach($ALERTAS as $aviso => $nada) {
				$tpl->setVariable(array(
					'mensagem' => $alertas[$aviso]['mensagem']
				));
				$tpl->parse("adicionar_mensagem");
			}
		}
	} else {
		$tpl_main = $templateBO->carregarCabecalhoRodapeSomente();

		$tpl_main->setVariable(array(
			'conteudo_topo'  => '<link rel="stylesheet" href="'.$ROOT.'css/esqueci_senha_emural.css" type="text/css" />'
		));
		$tpl_main->parse("adicionar_conteudo_topo");

		$alertasBO = new AlertasBO();
		$alertasBO->preencheAlertas($tpl_main);
	}

	$templateBO->iniciarGenerico($tpl);

	$tpl_main->setVariable(array(
		'titulo' => "Esqueci Minha Senha",
		'conteudo'  => $tpl->get()
	));
	$tpl_main->show();
}

?>
