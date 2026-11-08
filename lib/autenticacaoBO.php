<?php

require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/SIBO.php';
require_once $ROOT_PATH.'lib/professoresBO.php';
require_once $ROOT_PATH.'lib/monitoresBO.php';
require_once $ROOT_PATH.'lib/alunosBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';

require_once dirname(__FILE__).'/seguranca.php';

require_once 'HTTP.php';

class AutenticacaoBO
{
	private $linkBO;

	// Evita recursão infinita ao provisionar usuários vindos do SI.
	private $provisionando = false;

	function __construct()
	{
		$this->linkBO = new LinkBO();
	}


	public function redirecionarCasoLogado()
	{
		seg_iniciar_sessao();

		if (isset($_SESSION["coordenador"])) {
			HTTP::redirect($this->linkBO->getCoordenador());
			exit;
		} else if (isset($_SESSION["professor"])) {
			HTTP::redirect($this->linkBO->getProfessor());
			exit;
		} else if (isset($_SESSION["monitor"])) {
			//HTTP::redirect($this->linkBO->getMonitor());
			HTTP::redirect($this->linkBO->getIndex());
			exit;
		} else if (isset($_SESSION["aluno"])) {
			HTTP::redirect($this->linkBO->getAluno());
			exit;
		}
	}


	public function login($login)
	{
		GLOBAL $ALERTAS;

		seg_iniciar_sessao();

		if (!is_string($login->usuario) || !is_string($login->senha) || !strlen($login->usuario) || !strlen($login->senha)) {
			$ALERTAS["LSNC"] = "";
			return;
		}

		if (seg_login_bloqueado($login->usuario)) {
			$ALERTAS["LBLQ"] = "";
			return;
		}

		$SIBO = new SIBO();
		$pessoasBO = new PessoasBO();
		$professoresBO = new ProfessoresBO();
		$monitoresBO = new MonitoresBO();
		$alunosBO = new AlunosBO();
		$turmasBO = new TurmasBO();

		$pessoa = $pessoasBO->retornaPorUsuario($login->usuario);

		//não está na base de dados
		if($pessoa === null) {
			$usuarioSI = $SIBO->retornaUsuarioSIPorLogin($login->usuario);

			if($usuarioSI !== null && !$this->provisionando) {
				switch ($usuarioSI->tipo) {
					case "professor":
						$this->provisionando = true;
						$professoresBO->inserir($usuarioSI);
						$this->login($login);
						return;
					case "student":
						$this->provisionando = true;
						$monitoresBO->inserir($usuarioSI);
						$this->login($login);
						return;
				}
			}

			seg_login_registrar_falha($login->usuario);
			$ALERTAS["LSNC"] = "";
			return;
		}

		$autenticado = false;

		if (seg_verificar_senha($login->senha, $pessoa->senha)) {
			$autenticado = true;

			if (seg_senha_precisa_rehash($pessoa->senha)) {
				$pessoasBO->mudarSenha($pessoa->codigo, $login->senha);
			}
		} elseif (strcmp($pessoa->tipo,"professor") == 0 || strcmp($pessoa->tipo,"monitor") == 0) {
			//procurar no SI se é um professor ou monitor que mudou a senha.
			$usuarioSI = $SIBO->retornaUsuarioSIPorLogin($login->usuario);

			if ($usuarioSI !== null && seg_verificar_senha($login->senha, $usuarioSI->senha)) {
				$pessoasBO->mudarSenha($pessoa->codigo, $login->senha);
				$autenticado = true;
			}
		}

		// Alunos sem senha cadastrada não podem mais entrar com o sobrenome:
		// precisam concluir o cadastro (cadastro.php) ou usar "Esqueci minha senha".

		if (!$autenticado) {
			seg_login_registrar_falha($login->usuario);
			$ALERTAS["LSNC"] = "";
			return;
		}

		seg_login_limpar_falhas($login->usuario);

		// Evita fixação de sessão.
		session_regenerate_id(true);

		switch ($pessoa->tipo) {
			case "coord":
				$coordenador = $pessoa;
				$_SESSION["coordenador"] = serialize($coordenador);
				break;
			case "professor":
				$professor = $professoresBO->retornaPorCodigo($pessoa->codigo);
				$_SESSION["professor"] = serialize($professor);
				$turmasBO->atualizacaoTurmasProfessor($professor);
				break;
			case "monitor":
				$monitor = $monitoresBO->retornaPorCodigo($pessoa->codigo);
				$_SESSION["monitor"] = serialize($monitor);
				break;
			case "aluno":
				$aluno = $alunosBO->retornaPorCodigo($pessoa->codigo);
				$_SESSION["aluno"] = serialize($aluno);
				break;
		}

		$this->redirecionarCasoLogado();
	}


	public function verificarProfessor($codigo = false)
	{
		return $this->verificarPessoa("professor", $codigo);
	}


	public function verificarAluno($precisa_email_confirmado = true)
	{
		$aluno = $this->verificarPessoa("aluno", false);

		if (!$precisa_email_confirmado) {
			return $aluno;
		} elseif ($precisa_email_confirmado & strcmp($aluno->email_valido,'t') == 0) {
			return $aluno;
		} else {
			if (strlen($aluno->email) && strlen($aluno->email_confirmacao)) {
				$get["NOTY_ENCON"] = "";
			} else {
				$get["NOTY_ENCAD"] = "";
			}
			HTTP::redirect($this->linkBO->getAlunoEmail($get));
		}
	}


	public function verificarCoordenador()
	{
		return $this->verificarPessoa("coordenador", false);
	}


	private function verificarPessoa($tipo, $codigo)
	{
		seg_iniciar_sessao();

		$result = false;

		if (isset($_SESSION[$tipo])) {
			$pessoa = unserialize($_SESSION[$tipo]);

			if(strcmp($pessoa->codigo, $codigo) == 0 || $codigo === false) {
				$result = true;
			}
		}

		if(!$result) {
			$this->casoFalso();
			exit;
		}

		return $pessoa;
	}


	public function recarregaPessoa($pessoa,$tipo)
	{
		$_SESSION[$tipo] = serialize($pessoa);
	}


	private function casoFalso()
	{
		$get["NOTY_UNL"] = "";

		HTTP::redirect($this->linkBO->getIndex($get));
	}


	public function pode_logar($usuario, $senha_digitada)
	{
		$SIBO = new SIBO();
		$pessoasBO = new PessoasBO();

		$retorno = new stdClass();
		$retorno->success = false;

		if (!is_string($usuario) || !is_string($senha_digitada) || !strlen($usuario) || !strlen($senha_digitada)) {
			$retorno->reason = "SNC"; //Senha não confere
			return $retorno;
		}

		if (seg_login_bloqueado($usuario)) {
			$retorno->reason = "BLQ"; //Bloqueado temporariamente por excesso de tentativas
			return $retorno;
		}

		$pessoa = $pessoasBO->retornaPorUsuario($usuario);

		//não está na base de dados
		if($pessoa === null) {
			$usuarioSI = $SIBO->retornaUsuarioSIPorLogin($usuario);

			if($usuarioSI !== null && !$this->provisionando) {
				switch ($usuarioSI->tipo) {
					case "professor":
						$this->provisionando = true;
						$professoresBO = new ProfessoresBO();
						$professoresBO->inserir($usuarioSI);
						return $this->pode_logar($usuario, $senha_digitada);
					case "student":
						$this->provisionando = true;
						$monitoresBO = new MonitoresBO();
						$monitoresBO->inserir($usuarioSI);
						return $this->pode_logar($usuario, $senha_digitada);
				}
			}

			seg_login_registrar_falha($usuario);
			$retorno->reason = "SNC"; //Senha não confere
			return $retorno;
		}

		if(strlen($pessoa->senha) == 0) {
			$retorno->reason = "PSS"; //Pessoa está com senha em branco (Pessoa sem senha)
		} elseif(strcmp($pessoa->tipo,"aluno") == 0 && (strlen($pessoa->email) == 0 || !strcmp($pessoa->email_valido, "f"))) {
			$retorno->reason = "NPE"; //Não possui email
		} elseif(seg_verificar_senha($senha_digitada, $pessoa->senha)) {
			if (seg_senha_precisa_rehash($pessoa->senha)) {
				$pessoasBO->mudarSenha($pessoa->codigo, $senha_digitada);
			}
			$retorno->success = true;
		} elseif(strcmp($pessoa->tipo,"professor") == 0 || strcmp($pessoa->tipo,"monitor") == 0) {
			//procurar no SI se é um professor ou monitor que mudou a senha.
			$usuarioSI = $SIBO->retornaUsuarioSIPorLogin($usuario);

			if ($usuarioSI !== null && seg_verificar_senha($senha_digitada, $usuarioSI->senha)) {
				$pessoasBO->mudarSenha($pessoa->codigo, $senha_digitada);
				$retorno->success = true;
			} else {
				$retorno->reason = "SNC"; //Senha não confere
			}
		} else {
			$retorno->reason = "SNC"; //Senha não confere
		}

		if ($retorno->success) {
			seg_login_limpar_falhas($usuario);
		} else {
			seg_login_registrar_falha($usuario);
		}

		return $retorno;
	}


	public function logout()
	{
		seg_iniciar_sessao();
		session_unset();
		session_destroy();
	}
}
?>
