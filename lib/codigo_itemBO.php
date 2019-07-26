<?php

require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH."persistencia/codigo_itemDAO.php";

class CodigoItemBO extends BO
{
	function __construct()
	{
		$this->DAO = new Codigo_ItemDAO();
	}


	public function retornaAutoSuggestTipoAvaliacao($inicio)
	{
		if(strlen($inicio)>0) {
			$obj_ret = $this->DAO->recuperaAutoSuggestTipoAvaliacao($inicio);

			if(count($obj_ret)) {
				$retorno = $obj_ret;
			} else {
				$retorno = null;
			}
		} else {
			$retorno =  null;
		}

		return $retorno;
	}


	public function inserirTipoAvaliacao($valor)
	{
		if(strlen($valor)>0) {
			$inserir["descricao_resumida_2"] = substr(mb_strtolower($valor,mb_detect_encoding($valor)),0,20);

			$item = $this->retornaTipoAvaliacaoPorDescricaoResumida($inserir["descricao_resumida_2"]);
			if($item == null) {
				$inserir["descricao"] = mb_convert_case($valor, MB_CASE_TITLE, mb_detect_encoding($valor));
				$inserir["tipo"] = AVALIACAO_TIPO;

				return $this->DAO->inserir($inserir);
			}
		} else {
			$item = null;
		}
		return $item;
	}


	public function retornaTipoAvaliacaoPorDescricaoResumida($descricao_resumida2)
	{
		if(strlen($descricao_resumida2)>0) {

			$obj_ret = $this->DAO->recuperaPorTipoDescricaoResumida2(AVALIACAO_TIPO,$descricao_resumida2);

			if(count($obj_ret)) {
				$retorno = $obj_ret[0];
			} else {
				$retorno = null;
			}
		} else {
			$retorno =  null;
		}

		return $retorno;
	}
}
?>