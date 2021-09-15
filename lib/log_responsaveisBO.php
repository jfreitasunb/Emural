<?php

require_once $ROOT_PATH."persistencia/log_responsaveisDAO.php";
require_once $ROOT_PATH.'lib/bo.php';

class LogResponsaveisBO extends BO
{
	function __construct()
	{
		$this->DAO = new LogResponsaveisDAO();
	}


	public function preenchePaginaTurma($tpl, $turma)
	{
		$filtro["ava_ctur"] = $turma->codigo;
		$ordem["data_hora"] = "DESC";

		$lista = $this->DAO->recuperaDeFiltroComResponsaveisAvaliacoesMonitor($filtro,$ordem);

		if(count($lista)) {
			foreach($lista as $log)
			{
				$preenche->nome = $log->nome;
				$preenche->acao = $log->descricao;
				$preenche->data = $data;
				$preenche->hora = $hora;

				$this->preencherObjeto($tpl,$preenche,"monitor_","adicionar_acao_monitor");
			}
		}
	}
}
?>