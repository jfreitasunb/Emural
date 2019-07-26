<?php
require_once '../conf/default.php';

require_once $ROOT_PATH.'lib/semestresBO.php';

require_once $ROOT_PATH."persistencia/turmasDAO.php";

//$codigo_semestre = $_GET['a'];

if(isset($_POST['codigoSemestre'])) {
	$codigo_semestre = $_POST['codigoSemestre'];
} else {
	$codigo_semestre == null;
}

if(isset($_POST['codigoDisciplina'])) {
	$codigo_disciplina = $_POST['codigoDisciplina'];
} else {
	$codigo_disciplina == null;
}

if(strlen($codigo_semestre) > 0) {
	$semestresBO = new SemestresBO();
	$turmasDAO = new TurmasDAO();

	$semestre = $semestresBO->retornaPorCodigo($codigo_semestre);


	$filtro["ano"] = $semestre->ano;
	$filtro["semestre"] = $semestre->semestre;

	if($codigo_disciplina !== null) {
		$filtro["disciplina"] = $codigo_disciplina;
	}

	$ordem['disciplina_descricao'] = "ASC";
	$ordem['descricao'] = "ASC";

	$lista_turmas = & $turmasDAO->recuperaDeFiltro($filtro,$ordem);

	if(count($lista_turmas)) {
		echo '<option value="0"></option>';
		foreach($lista_turmas as $turma)
		{
         	echo '<option value="'.$turma->codigo.'">'.$turma->disciplina_descricao.' - '.$turma->descricao.'</option>';
		}
	} else {
		echo '';
	}
} else {
	echo '';
}
?>