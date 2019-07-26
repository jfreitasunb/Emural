<?php

require_once $ROOT_PATH."persistencia/disciplinasDAO.php";
require_once $ROOT_PATH.'lib/bo.php';

class DisciplinasBO extends BO
{
	function __construct()
	{
		$this->DAO = & new DisciplinasDAO();
	}


	public function preencheCombo($tpl,$dados = null)
	{
		$ordem["descricao"] = "ASC";

		$lista_obj = & $this->DAO->recuperaDeFiltro(null,$ordem);

		$preencher = & new stdClass();
		foreach($lista_obj as $obj)
		{
			$preencher->codigo = $obj->codigo;
			$preencher->descricao = $obj->descricao;

			if($dados != null && $dados->disciplina == $obj->codigo) {
				$preencher->selected = "selected";
			} else {
				$preencher->selected = "";
			}

			$this->preencherObjeto($tpl,$preencher,"combo_disciplina_","adicionar_combo_disciplina");
		}
	}


	public function retornaArray()
	{
		$ordem["descricao"] = "ASC";

		$lista_obj = & $this->DAO->recuperaDeFiltro(null,$ordem);


		if(count($lista_obj)) {
			foreach($lista_obj as $obj)
			{
				$lista_retorno[$obj->codigo_cpd] = $obj;
			}
		} else {
			$lista_retorno = null;
		}
		return $lista_retorno;
	}


	public function cadastrar($disciplina)
	{
		if($disciplina !== null) {
			$return =  $this->DAO->inserir($disciplina);
		} else {
			$return = null;
		}
		return $return;
	}


	public function preencheCombosCoordenadorSemestre($tpl)
	{
		$ordem["descricao"] = "ASC";

		$lista_obj = & $this->DAO->recuperaDeFiltro(null,$ordem);

		$preencher = & new stdClass();
		foreach($lista_obj as $obj)
		{
			$preencher->codigo_cpd = $obj->codigo_cpd;
			$preencher->descricao = $obj->descricao;

			$this->preencherObjeto($tpl,$preencher,"combo_disciplina1_","adicionar_combo_disciplina1");
			$this->preencherObjeto($tpl,$preencher,"combo_disciplina2_","adicionar_combo_disciplina2");
		}
	}
}
?>