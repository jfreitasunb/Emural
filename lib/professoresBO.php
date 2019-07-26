<?php

require_once $ROOT_PATH."persistencia/professoresDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/SIBO.php';

class ProfessoresBO extends BO
{
	function __construct()
	{
		$this->DAO = new ProfessoresDAO();
	}


	public function inserir($dados)
	{
		$pessoasBO = new PessoasBO();

		$dados->tipo = 'professor';

		$pessoa = & $pessoasBO->inserir($dados);

		$insert['codigo'] = $pessoa->codigo;
		$insert['codigo_usuario_si'] = $dados->coduser;

		$professor = & $this->DAO->inserir($insert);

		return $this->retornaPorCodigo($professor->codigo);;
	}


	public function retornaPorCodigoSI($codigo_si)
	{
		if(strlen($codigo_si)>0) {
			$filtro["codigo_usuario_si"] = $codigo_si;

			$obj_ret = & $this->DAO->recuperaDeFiltro($filtro);

			if(count($obj_ret)) {
				$retorno = & $obj_ret[0];
			} else {
				$siBO = new SIBO();
				$usuario_si = $siBO->retornaUsuarioSIPorCodigoSI($codigo_si);
				$usuario_si->email = $usuario_si->usuario."@mat.unb.br";
				$professor = $this->inserir($usuario_si);
				$retorno = & $professor;
			}
		} else {
			$retorno =  null;
		}

		return $retorno;
	}
}
?>