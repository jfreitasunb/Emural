<?php

class BO
{
	protected $DAO;


	public function preencherLista($tpl,$lista,$prefixo = null,$parse = null,$parse_master = null)
	{
		foreach($lista as $obj)
		{
			$this->preencherObjeto($tpl,$obj,$prefixo,$parse);
		}
			if(strlen($parse_master)) {
				$tpl->parse($parse_master);
			}
	}


	public function preencherObjeto($tpl,$obj,$prefixo = "",$parse = null)
	{
		if($obj !== null) {
			foreach($obj as $nome => $valor)
			{
				$tpl->setVariable(array(
					$prefixo.$nome  => $valor
				));
			}
			if(strlen($parse)) {
				$tpl->parse($parse);
			}
		}
	}


	public function retornaPorCodigo($codigo)
	{
		$retorno = null;
		if(strlen($codigo)>0) {
			$filtro["codigo"] = $codigo;

			$obj_ret = & $this->DAO->recuperaDeFiltro($filtro);

			if(count($obj_ret)) {
				$retorno = & $obj_ret[0];
			}
		}

		return $retorno;
	}
}
?>