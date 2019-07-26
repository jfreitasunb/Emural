<?php

require_once $ROOT_PATH."persistencia/pessoasDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/alunosBO.php';
require_once $ROOT_PATH.'lib/moodleBO.php';

require_once 'HTTP.php';

class PessoasBO extends BO
{
	function __construct()
	{
		$this->DAO = new PessoasDAO();
	}


	public function retornaPorUsuario($usuario)
	{
		$filtro['usuario'] = $usuario;

		$lista = & $this->DAO->recuperaDeFiltro($filtro);

		if(count($lista)) {
			return $lista[0];
		} else {
			return null;
		}
	}


	public function inserir($dados)
	{
		$insert['nome'] = preg_replace('/( Tr){0,1}[\r\n\t\f\s\n ]*$/', '', $dados->nome);
		$insert['usuario'] = $dados->usuario;
		if(isset($dados->senha)) {
			$insert['senha'] = $dados->senha;
		}
		$insert['tipo'] = $dados->tipo;

		if(isset($dados->email)) {
			$insert['email'] = $dados->email;
		}

		$pessoa = & $this->DAO->inserir($insert);

		return $pessoa;
	}


	public function mudarSenha($codigo_pessoa, $senha)
	{
		GLOBAL $SENHAS_CODIFICADAS;

		if($SENHAS_CODIFICADAS) {
			$senha = crypt($senha);
		}

		$campos['senha'] = $senha;

		$filtro['codigo'] = $codigo_pessoa;

		$this->DAO->updateCamposDeFiltro($campos, $filtro);
	}


	public function mudarSenhaPessoa($senhas, $pessoa)
	{
		GLOBAL $ALERTAS, $SENHAS_CODIFICADAS;

		if($SENHAS_CODIFICADAS) {
			$senhas['senha_atual'] = crypt($senhas['senha_atual'],$pessoa->senha);
		}

		if($senhas['senha_atual'] == $pessoa->senha || (strcmp($pessoa->tipo,"aluno") == 0 && strlen($pessoa->senha) == 0)) {
			if($senhas['nova_senha'] == $senhas['nova_senha_2']) {

				$this->mudarSenha($pessoa->codigo, $senhas['nova_senha']);

				$ALERTAS["SAS"] = ""; // Senha alterada com sucesso
			} else {
				$ALERTAS["SNI"] = ""; //Senhas novas não são iguais
			}
		} else {
			$ALERTAS["SNC"] = ""; //Senha não confere
		}
	}


	public function retornaUltimoNome($pessoa)
	{
		$nome_array = explode(" ", $pessoa->nome);

		return $nome_array[count($nome_array) - 1];
	}


	public function alteraSenhaAlunoPorCoordenador($aluno_dados)
	{
		GLOBAL $ALERTAS, $SENHAS_CODIFICADAS;

		$alunosBO = new AlunosBO();
		$aluno = $alunosBO->retornaPorMatricula($aluno_dados->matricula);

		if($aluno_dados->nova_senha == $aluno_dados->nova_senha_2) {
			$this->mudarSenha($aluno->codigo, $aluno_dados->nova_senha);

			$ALERTAS["SAS"] = ""; // Senha alterada com sucesso
		} else {
			$ALERTAS["SNI"] = ""; //Senhas novas não são iguais
		}
	}


	public function alteraCodigoMoodle(&$pessoa, $codigo_moodle)
	{
		$campos['codigo_moodle'] = $codigo_moodle;

		$filtro['codigo'] = $pessoa->codigo;

		$this->DAO->updateCamposDeFiltro($campos, $filtro);

		$pessoa->codigo_moodle = $codigo_moodle;
	}


	public function mudarEmailPessoa(&$pessoa, $email)
	{
		if (is_numeric($pessoa)) {
			$pessoa = $this->retornaPorCodigo($pessoa);
		}

		GLOBAL $ALERTAS, $CONCATENACAO_VALIDACAO_EMAIL;

		$lista_validacao = array();

		if (strlen($email)) {
			$filtro_validacao['email'] = $email;

			$lista_validacao = $this->DAO->recuperaDeFiltro($filtro_validacao);

			if (count($lista_validacao)) {
				$pessoa_validacao = $lista_validacao[0];

				if (strcmp($pessoa_validacao->usuario, $pessoa->usuario) == 0) {
					if (strcmp($pessoa->email_valido,'t') == 0) {
						$ALERTAS["EJCC"] = "";

						return false;
					} else {
						$lista_validacao = array();
					}
				}
			}
		}

		if (count($lista_validacao)) {
			$ALERTAS["EJU"] = "";

			return false;
		} else {
			$filtro['codigo'] = $pessoa->codigo;

			$confirmacao = $CONCATENACAO_VALIDACAO_EMAIL.$email.date("d-m-Y H:i:s:u");
			$update['email_valido'] = 'false';
			$update['email'] = $email;
			$update['email_confirmacao'] = md5($confirmacao);

			$this->DAO->updateCamposDeFiltro($update, $filtro);

			$pessoa->email = $update['email'];
			$pessoa->email_valido = $update['email_valido'];
			$pessoa->email_confirmacao = $update['email_confirmacao'];

			$ALERTAS["ECAC"] = "";

			return true;
		}
	}


	public function preenchePaginaEmail($tpl, $pessoa)
	{
		$preenche = new stdClass();
		$preenche->email = $pessoa->email;

		$this->preencherObjeto($tpl, $pessoa);
	}


	public function confirmarEmail($codigo_confirmacao)
	{
		if ($codigo_confirmacao !== NULL) {
			$pessoa_codigo = substr($codigo_confirmacao, 32);
			$codigo_confirmacao = substr($codigo_confirmacao, 0, 32);

			$pessoa = $this->retornaPorCodigo($pessoa_codigo);

			if (strcmp($pessoa->email_confirmacao, $codigo_confirmacao) == 0) {
				$update['email_valido'] = 'true';
				$update['email_confirmacao'] = "";

				$filtro['codigo'] = $pessoa_codigo;

				$this->DAO->updateCamposDeFiltro($update, $filtro);

				$moodleBO = new MoodleBO();
				$moodleBO->usuarioAtualizar($pessoa);

				$alerta["NOTY_ECS"] = "";
			} else {
				$alerta["NOTY_ECE"] = "";
			}
		} else {
			$alerta["NOTY_ECE"] = "";
		}
	}


	public function gerarSenha($pessoa)
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$symbol = "!@#$%&*:;<>?-=+_";

		$alphaLength = strlen($alphabet) - 1;
		$symLength = strlen($symbol) - 1;

		$pass = array();

		for ($i = 0; $i < 9; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$n = rand(0, $symLength);

	    return implode($pass).$symbol[$n];
	}


	public function esqueciMinhaSenha(&$pessoa)
	{
		GLOBAL $CONCATENACAO_VALIDACAO_EMAIL;

		$filtro['codigo'] = $pessoa->codigo;

		$confirmacao = $CONCATENACAO_VALIDACAO_EMAIL.$pessoa->codigo.date("d-m-Y H:i:s:u");

		$update['senha_mudanca'] = md5($confirmacao);

		$this->DAO->updateCamposDeFiltro($update, $filtro);

		$pessoa->senha_mudanca = $update['senha_mudanca'];
	}


	public function retornaPorHastEsqueciSenha($hast_esqueci)
	{
		$return = null;

		if ($hast_esqueci !== NULL && strlen($hast_esqueci) > 32) {
			$pessoa_codigo = substr($hast_esqueci, 32);
			$hast_esqueci = substr($hast_esqueci, 0, 32);

			$pessoa = $this->retornaPorCodigo($pessoa_codigo);

			if (strcmp($pessoa->senha_mudanca, $hast_esqueci) == 0) {
				$return = $pessoa;
			}
		}

		return $return;
	}


	public function mudarSenhaEsqueciSenha($pessoa, $senha)
	{
		$filtro['codigo'] = $pessoa->codigo;

		$update['senha_mudanca'] = null;

		$this->DAO->updateCamposDeFiltro($update, $filtro);

		$this->mudarSenha($pessoa->codigo, $senha);
	}


	public function zerarCodigoMoodle()
	{
		$campos['codigo_moodle'] = null;

		$this->DAO->updateCamposDeFiltro($campos);
	}
}
?>