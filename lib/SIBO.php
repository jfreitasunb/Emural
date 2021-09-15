<?php

require_once $ROOT_PATH."persistencia/SIDAO.php";
require_once $ROOT_PATH.'lib/bo.php';

//require_once 'Date.php';

class SIBO extends BO
{
	function __construct()
	{
		$this->DAO = new SIDAO();
	}


	public function retornaUsuarioSIPorLogin($usuario)
	{
		$filtro["usuario"] = $usuario;

		$lista = $this->DAO->recuperaDeUsuario($filtro);

		if(count($lista)) {
			return $lista[0];
		} else {
			return null;
		}
	}


	public function retornaUsuarioSIPorCodigoSI($codigo_si)
	{
		$filtro["coduser"] = $codigo_si;

		$lista = $this->DAO->recuperaDeUsuario($filtro);

		if(count($lista)) {
			return $lista[0];
		} else {
			return null;
		}
	}


	public function retornaArrayTurmasPorSemestre($semestre,$professor = null)
	{
		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;
		if($professor !== null) {
			$filtro["professor"] = $professor->codigo_usuario_si;
		}

		$ordem["professor"] = "ASC";
		$ordem["disciplina_descricao"] = "ASC";
		$ordem["descricao"] = "ASC";


		$lista_obj = $this->DAO->recuperaDeTurma($filtro,$ordem);


		if(count($lista_obj)) {
			foreach($lista_obj as $obj)
			{
				$lista_retorno[$obj->codigo_cpd.$obj->descricao] = $obj;
			}
		} else {
			$lista_retorno = null;
		}
		return $lista_retorno;
	}


	public function retornaTurma($turma)
	{
		$filtro["ano"] = $turma->ano;
		$filtro["semestre"] = $turma->semestre;
		$filtro["codigo_cpd"] = $turma->codigo_cpd;
		$filtro["descricao"] = $turma->descricao;

		$lista = $this->DAO->recuperaDeTurma($filtro);

		if(count($lista)) {
			return $lista[0];
		} else {
			return null;
		}
	}


	public function retornaArrayDisciplinasMagistrais($semestre)
	{
		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;

		$ordem["disciplina_descricao"] = "ASC";

		$lista_obj = $this->DAO->recuperaDeDisciplinasMagistrais($filtro,$ordem);


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
}
?>