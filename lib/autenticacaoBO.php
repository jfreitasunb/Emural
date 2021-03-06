<?php

require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/SIBO.php';
require_once $ROOT_PATH.'lib/professoresBO.php';
require_once $ROOT_PATH.'lib/monitoresBO.php';
require_once $ROOT_PATH.'lib/alunosBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';

require_once 'HTTP.php';

class AutenticacaoBO
{
	private $linkBO;

	function __construct()
	{
		$this->linkBO = new LinkBO();
	}


	public function redirecionarCasoLogado()
	{
		session_start();

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
		GLOBAL $SENHAS_CODIFICADAS, $ALERTAS;

		$login->senha_digitada = $login->senha;

		session_start();

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

			if($usuarioSI !== null) {
				switch ($usuarioSI->tipo) {
					case "professor":
						$professoresBO->inserir($usuarioSI);
						$this->login($login);
						return;
					case "student":
						$monitoresBO->inserir($usuarioSI);
						$this->login($login);
						return;
				}
			} else {
				$ALERTAS["LSNC"] = "";
			}
		} else {
			//usuario existe e senha confere

			if($SENHAS_CODIFICADAS) {
				$login->senha = crypt($login->senha_digitada,$pessoa->senha);
			}

			if(strcmp($pessoa->senha, $login->senha) == 0) {
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
			}
			//usuario existe e senha não confere
			else {
				//aluno ainda não cadastrou a senha
				if(strcmp($pessoa->tipo,"aluno") == 0 && strlen($pessoa->senha) == 0) {

					$ultimo_nome = trim($pessoasBO->retornaUltimoNome($pessoa));
					if($SENHAS_CODIFICADAS) {
						$ultimo_nome = crypt($ultimo_nome,$login->senha);
					}

					if(strcmp($ultimo_nome, $login->senha) == 0) {
						$aluno = $alunosBO->retornaPorCodigo($pessoa->codigo);
						$_SESSION["aluno"] = serialize($aluno);
					} else {
						$ALERTAS["LSNC"] = "";
					}
				} else {
					//procurar no SI se é um professor ou monitor que mudou a senha.
					if(strcmp($pessoa->tipo,"professor") == 0 || strcmp($pessoa->tipo,"monitor") == 0) {
						$usuarioSI = $SIBO->retornaUsuarioSIPorLogin($login->usuario);

						if($SENHAS_CODIFICADAS) {
							$login->senha = crypt($login->senha_digitada,$usuarioSI->senha);
						}

						if(strcmp($usuarioSI->senha, $login->senha) == 0){
							$pessoasBO->mudarSenha($pessoa->codigo, $login->senha);

							switch ($pessoa->tipo) {
								case "professor":
									$professor = $professoresBO->retornaPorCodigo($pessoa->codigo);
									$_SESSION["professor"] = serialize($professor);
									$turmasBO->atualizacaoTurmasProfessor($professor);
									break;
								case "monitor":
									$monitor = $monitoresBO->retornaPorCodigo($pessoa->codigo);
									$_SESSION["monitor"] = serialize($monitor);
									break;
							}
						} else {
							$ALERTAS["LSNC"] = "";
						}
					} else {
						$ALERTAS["LSNC"] = "";
					}
				}
			}
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
		session_start();

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
		GLOBAL $SENHAS_CODIFICADAS;

		$senha = $senha_digitada;

		$SIBO = new SIBO();
		$pessoasBO = new PessoasBO();

		$retorno = new stdClass();
		$retorno->success = false;

		$pessoa = $pessoasBO->retornaPorUsuario($usuario);

		//não está na base de dados
		if($pessoa === null) {
			$usuarioSI = $SIBO->retornaUsuarioSIPorLogin($usuario);

			if($usuarioSI !== null) {
				switch ($usuarioSI->tipo) {
					case "professor":
						$professoresBO = new ProfessoresBO();
						$professoresBO->inserir($usuarioSI);
						return $this->pode_logar($usuario, $senha_digitada);
					case "student":
						$monitoresBO = new MonitoresBO();
						$monitoresBO->inserir($usuarioSI);
						return $this->pode_logar($usuario, $senha_digitada);
				}
			} else {
				$retorno->reason = "SNC"; //Senha não confere
			}
		} else {
			if(strlen($pessoa->senha) == 0) {
				$retorno->reason = "PSS"; //Pessoa está com senha em branco (Pessoa sem senha)
			} else {
				if(strcmp($pessoa->tipo,"aluno") == 0 && (strlen($pessoa->email) == 0 || !strcmp($pessoa->email_valido, "f"))) {
					$retorno->reason = "NPE"; //Não possui email
				} else {
					if($SENHAS_CODIFICADAS) {
						$senha = crypt($senha_digitada,$pessoa->senha);
					}

					if(strcmp($pessoa->senha, $senha) == 0) {
						$retorno->success = true;
					} else {
						//procurar no SI se é um professor ou monitor que mudou a senha.
						if(strcmp($pessoa->tipo,"professor") == 0 || strcmp($pessoa->tipo,"monitor") == 0) {
							$usuarioSI = $SIBO->retornaUsuarioSIPorLogin($usuario);

							if ($usuarioSI !== null) {
								if($SENHAS_CODIFICADAS) {
									$senha = crypt($senha_digitada,$usuarioSI->senha);
								}

								if(strcmp($usuarioSI->senha, $senha) == 0) {
									$pessoasBO->mudarSenha($pessoa->codigo, $senha);
									$pessoa->senha = $senha;

									$retorno->success = true;
								} else {
									$retorno->reason = "SNC"; //Senha não confere
								}
							} else {
								$retorno->reason = "SNC"; //Senha não confere
							}
						} else {
							$retorno->reason = "SNC"; //Senha não confere
						}
					}
				}
			}
		}

		return $retorno;
	}


	public function logout()
	{
		session_start();
		session_unset();
		session_destroy();
	}
}
?>
