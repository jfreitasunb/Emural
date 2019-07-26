<?php

require_once $ROOT_PATH."persistencia/alunosDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';

class AlunosBO extends BO
{
	function __construct()
	{
		$this->DAO = new AlunosDAO();
	}


	public function retornaPorMatricula($matricula)
	{
		if(strlen($matricula)>0) {
			$filtro["matricula"] = $matricula;

			$obj_ret = $this->DAO->recuperaDeFiltro($filtro);

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


	public function retornaPorEmail($email)
	{
		if(strlen($email)>0) {
			$filtro["email"] = $email;

			$obj_ret = $this->DAO->recuperaDeFiltro($filtro);

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


	public function preencheComboOpcaoDeCurso($tpl,$dados)
	{
		$ordem["opcao_curso"] = "ASC";

		$lista_obj = $this->DAO->recuperaDistinctOpcaoCursoDeFiltro(null,$ordem);

		foreach($lista_obj as $obj)
		{
			$preencher->opcao_curso = $obj->opcao_curso;

			if($dados != null && $dados->opcao_curso == $obj->opcao_curso) {
				$preencher->selected = "selected";
			} else {
				$preencher->selected = "";
			}

			$this->preencherObjeto($tpl,$preencher,"combo_opcao_curso_","adicionar_combo_opcao_curso");
		}
	}


	public function inserir($dados)
	{
		$pessoasBO = new PessoasBO();

		$pessoa = new stdClass();
		$pessoa->tipo = 'aluno';
		$pessoa->nome = $dados->nome;
		$pessoa->usuario = $dados->matricula;

		$pessoa = $pessoasBO->inserir($pessoa);

		$insert['codigo'] = $pessoa->codigo;
		$insert['matricula'] = $dados->matricula;
		$insert['opcao_curso'] = $dados->opcao_curso;

		$aluno = $this->DAO->inserir($insert);

		return $this->retornaPorCodigo($aluno->codigo);
	}
}
?>