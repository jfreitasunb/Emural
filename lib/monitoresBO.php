<?php

require_once $ROOT_PATH."persistencia/monitoresDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

class MonitoresBO extends BO
{
	function __construct()
	{
		$this->DAO = new MonitoresDAO();
	}


	public function preencheCombo($tpl,$responsavel)
	{
		$filtro["status"] = "TRUE";

		$ordem["nome"] = "ASC";

		$lista_obj = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		foreach($lista_obj as $obj)
		{
			$preenche->valor = $obj->codigo;
			$preenche->descricao = $obj->nome;

			if($responsavel !== null && $responsavel->monitor == $obj->codigo) {
				$preenche->selected = "selected";
			} else {
				unset($preenche->selected);
			}

			$this->preencherObjeto($tpl,$preenche,"monitor_combo_","adcionar_monitor_combo");
		}
	}


	public function inserir($dados)
	{
		$pessoasBO = new PessoasBO();

		$dados->tipo = 'monitor';

		$pessoa = & $pessoasBO->inserir($dados);

		$insert['codigo'] = $pessoa->codigo;
		$insert['codigo_usuario_si'] = $dados->coduser;
		$insert['status'] = 'true';

		$professor = & $this->DAO->inserir($insert);

		return $this->retornaPorCodigo($professor->codigo);;
	}


	public function desativarMonitores()
	{
		$update['status'] = "false";

		$this->DAO->updateCamposDeFiltro($update,null);
	}
}
?>