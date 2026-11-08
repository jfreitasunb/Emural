<?php

require_once $ROOT_PATH."persistencia/pessoasDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/alunosBO.php';
require_once $ROOT_PATH.'lib/moodleBO.php';
require_once dirname(__FILE__).'/seguranca.php';

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

		$lista = $this->DAO->recuperaDeFiltro($filtro);

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

		if(isset($dados->email_valido)) {
			$insert['email_valido'] = $dados->email_valido;
		}

		$pessoa = $this->DAO->inserir($insert);

		return $pessoa;
	}


	public function mudarSenha($codigo_pessoa, $senha)
	{
		$campos['senha'] = seg_hash_senha($senha);

		$filtro['codigo'] = $codigo_pessoa;

		$this->DAO->updateCamposDeFiltro($campos, $filtro);
	}


	public function mudarSenhaPessoa($senhas, $pessoa)
	{
		GLOBAL $ALERTAS;

		// A senha atual é sempre conferida contra o valor do banco (e não o da sessão).
		$pessoa_banco = $this->retornaPorCodigo($pessoa->codigo);

		if($pessoa_banco !== null && seg_verificar_senha($senhas['senha_atual'], $pessoa_banco->senha)) {
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

		GLOBAL $ALERTAS;

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

			$update['email_valido'] = 'false';
			$update['email'] = $email;
			$update['email_confirmacao'] = seg_token_aleatorio(16);

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
		if (is_string($codigo_confirmacao) && strlen($codigo_confirmacao) > 32) {
			$pessoa_codigo = substr($codigo_confirmacao, 32);
			$codigo_confirmacao = substr($codigo_confirmacao, 0, 32);

			$pessoa = ctype_digit($pessoa_codigo) ? $this->retornaPorCodigo($pessoa_codigo) : null;

			if ($pessoa !== null && seg_comparar((string) $pessoa->email_confirmacao, $codigo_confirmacao)) {
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
			$n = seg_inteiro_aleatorio(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$n = seg_inteiro_aleatorio(0, $symLength);

	    return implode($pass).$symbol[$n];
	}


	public function esqueciMinhaSenha(&$pessoa)
	{
		$filtro['codigo'] = $pessoa->codigo;

		// O banco guarda "token|validade"; o link enviado leva só o token.
		$token = seg_token_aleatorio(16);
		$validade = time() + SEG_VALIDADE_LINK_SENHA;

		$update['senha_mudanca'] = $token."|".$validade;

		$this->DAO->updateCamposDeFiltro($update, $filtro);

		$pessoa->senha_mudanca = $token;
	}


	public function retornaPorHastEsqueciSenha($hast_esqueci)
	{
		$return = null;

		if ($hast_esqueci !== NULL && strlen($hast_esqueci) > 32) {


			$pessoa_codigo = substr($hast_esqueci, 32);

			$hast_esqueci = substr($hast_esqueci, 0, 32);


			$pessoa = ctype_digit($pessoa_codigo) ? $this->retornaPorCodigo($pessoa_codigo) : null;

			if ($pessoa !== null) {
				$partes = explode("|", (string) $pessoa->senha_mudanca);

				// Tokens antigos (sem validade) ou expirados não são aceitos.
				if (count($partes) == 2 && ctype_digit($partes[1]) && (int) $partes[1] >= time()
						&& seg_comparar($partes[0], $hast_esqueci)) {
					$pessoa->senha_mudanca = $partes[0];
					$return = $pessoa;
				}
			}
		}

		return $return;
	}


	public function mudarSenhaEsqueciSenha($pessoa, $senha)
	{
		$filtro['codigo'] = $pessoa->codigo;

		$update['senha_mudanca'] = null;
		// Quem usou o link recebido por e-mail comprovou ter acesso a ele.
		if (strlen($pessoa->email)) {
			$update['email_valido'] = 'true';
			$update['email_confirmacao'] = null;
		}

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
