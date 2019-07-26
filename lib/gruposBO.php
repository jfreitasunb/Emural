<?php

require_once $ROOT_PATH."persistencia/gruposDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/moodleBO.php';

class GruposBO extends BO
{
	function __construct()
	{
		$this->DAO = new GruposDAO();
	}


	public function retornaPorTurma($turma)
	{
		$turma_codigo = $turma;
		if (is_object($turma)) {
			$turma_codigo = $turma->codigo;
		} else if(is_array($turma)) {
			$turma_codigo = $turma['codigo'];
		}

		$filtro['turma'] = $turma_codigo;

		$lista = & $this->DAO->recuperaDeFiltro($filtro);

		if(count($lista)) {
			return $lista[0];
		} else {
			return null;
		}
	}


	public function retornaPorSemestreDisciplina($semestre, $disciplina)
	{
		$disciplina_codigo = $disciplina;
		if (is_object($disciplina)) {
			$disciplina_codigo = $disciplina->codigo;
		} else if(is_array($disciplina)) {
			$disciplina_codigo = $disciplina['codigo'];
		}

		$filtro['turma_disciplina'] = $disciplina_codigo;
		$filtro['ano'] = $semestre->ano;
		$filtro['semestre'] = $semestre->semestre;

		$lista = & $this->DAO->recuperaDeFiltro($filtro);

		if(count($lista)) {
			return $lista[0];
		} else {
			return null;
		}
	}


	public function cadastrar($turma)
	{
		$insert['turma'] = $turma->codigo;
		$grupo = & $this->DAO->inserir($insert);

		$filtro['codigo'] = $grupo->codigo;

		$lista_grupos = $this->DAO->recuperaDeFiltro($filtro);

		$grupo = $lista_grupos[0];

		$moodleBO = new MoodleBO();
		$moodleBO->grupoCriar($grupo);

		return $grupo;
	}


	public function alteraCodigoMoodle(&$grupo, $codigo_moodle)
	{
		$campos['codigo_moodle'] = $codigo_moodle;

		$filtro['codigo'] = $grupo->codigo;

		$this->DAO->updateCamposDeFiltro($campos, $filtro);

		$grupo->codigo_moodle = $codigo_moodle;
	}


	public function retornaDisciplinasQuePossuemGrupoNoSemestre($semestre)
	{
		$lista = & $this->DAO->recuperaDisciplinasQuePossuemGrupoNoSemestre($semestre);

		if(count($lista)) {
			return $lista;
		} else {
			return null;
		}
	}
}
?>