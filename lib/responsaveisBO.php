<?php

require_once $ROOT_PATH."persistencia/responsaveisDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/linkBO.php';

class ResponsaveisBO extends BO
{
	function __construct()
	{
		$this->DAO = new ResponsaveisDAO();
		$this->linkBO = new LinkBO();
	}


	public function retornaPorCodigoETurma($codigo,$turma)
	{
		if(strlen($codigo)>0) {
			$filtro["codigo"] = $codigo;

			$obj_ret = & $this->DAO->recuperaDeAvaliacao($filtro);

			if(count($obj_ret)) {
				$obj = & $obj_ret[0];
			} else {
				$obj = null;
			}
		} else {
			$obj =  null;
		}

		if($obj !== null && $obj->turma == $turma->codigo) {
			return $obj;
		} else {
			return null;
		}
	}


	public function preencherMonitores($tpl,$turma,$responsavel)
	{
		$filtro['ava_ctur'] = $turma->codigo;
		$filtro['res_vali'] = "true";

		$ordem["nome_avaliacao"] = "ASC";
		$ordem["nome_monitor"] = "ASC";

		$lista_obj = & $this->DAO->recuperaDeAvaliacaoMonitor($filtro);

		if(count($lista_obj)) {
			foreach($lista_obj as $obj)
			{
				$preenche->avaiacao_nome = $obj->nome_avaliacao;
				$preenche->nome = $obj->nome_monitor;
				$preenche->link_editar = $this->linkBO->getMonitores($turma,$obj);

				$this->preencherObjeto($tpl,$preenche,"monitor_","adcionar_monitor");
			}
		}

		if($responsavel !== null) {
			unset($preenche);
			if($responsavel->lancar)
				$preenche->lancar_checked = "checked";
			if($responsavel->editar)
				$preenche->editar_checked = "checked";
			if($responsavel->confiar)
				$preenche->confiar_checked = "checked";

			$this->preencherObjeto($tpl,$preenche);
		}
	}


	public function inserirAtualizar($valores,$responsavel = null)
	{
		GLOBAL $ALERTAS;

		if($responsavel === null) {
			$valores->valido = 'true';
			$this->DAO->inserir($valores);
			$ALERTAS["MONIS"] = "";
		} else {
			$filtro['codigo'] = $responsavel->codigo;
			$this->DAO->updateCamposDeFiltro($valores,$filtro);
			$ALERTAS["MONAS"] = "";
		}
	}


	public function desativar($responsavel)
	{
		if($responsavel !== null) {
			$valores["valido"] = "false";

			$filtro['codigo'] = $responsavel->codigo;

			$this->DAO->updateCamposDeFiltro($valores,$filtro);
		}
	}
}
?>