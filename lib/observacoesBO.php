<?php

require_once $ROOT_PATH."persistencia/observacoesDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/utilBO.php';

class ObservacoesBO extends BO
{
	private $linkBO;

	function __construct()
	{
		$this->DAO = new ObservacoesDAO();
		$this->linkBO = new LinkBO();
	}


	public function preencheValidas($tpl,$turma,$observacao_ativa)
	{
		$filtro["turma"] = $turma->codigo;
		$filtro["valido"] = "true";

		$ordem["data_divulgacao"] = "DESC";
		$ordem["codigo"] = "ASC";

		$lista_observacoes = $this->DAO->recuperaDeFiltro($filtro,$ordem);

		if(count($lista_observacoes)) {
			foreach($lista_observacoes as $observacao)
			{
				$preenche->titulo = $observacao->titulo;
				$preenche->descricao = htmlspecialchars($observacao->descricao);
				$preenche->link_editar = $this->linkBO->getAvisos($turma,$observacao);

				if(UtilBO::compararDatas($observacao->data_divulgacao) > 0) {
					$preenche->data_publicado_futuro = $observacao->data_divulgacao;
					unset($preenche->data_publicado_passado);
				} else {
					$preenche->data_publicado_passado = $observacao->data_divulgacao;
					unset($preenche->data_publicado_futuro);
				}

				$this->preencherObjeto($tpl,$preenche,"observacao_","adcionar_observacao");
			}
		}
	}


	public function inserirAtualizar($valores,$observacao = null)
	{
		GLOBAL $ALERTAS;

		if(!strlen($valores->data_divulgacao)) {
			$valores->data_divulgacao = date("d/m/Y");
		}

		if($observacao === null) {
			$this->DAO->inserir($valores);
			$ALERTAS["AVIIS"] = "";
		} else {
			$filtro['codigo'] = $observacao->codigo;
			$this->DAO->updateCamposDeFiltro($valores,$filtro);
			$ALERTAS["AVISS"] = "";
		}
	}


	public function retornaPorCodigoETurma($codigo,$turma)
	{
		if(strlen($codigo)>0) {
			$filtro["codigo"] = $codigo;
			$filtro["valido"] = "true";

			$obj_ret = $this->DAO->recuperaDeFiltro($filtro);

			if(count($obj_ret)) {
				$observacao = $obj_ret[0];
			} else {
				$observacao = null;
			}
		} else {
			$observacao =  null;
		}

		if($observacao !== null && $observacao->turma == $turma->codigo) {
			return $observacao;
		} else {
			return null;
		}
	}


	public function desativar($observacao)
	{
		if($observacao !== null) {
			$valores["valido"] = "false";

			$filtro['codigo'] = $observacao->codigo;

			$this->DAO->updateCamposDeFiltro($valores,$filtro);
		}
	}
}
?>