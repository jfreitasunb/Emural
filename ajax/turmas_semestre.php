<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/seguranca.php';
require_once $ROOT_PATH.'lib/autenticacaoBO.php';

require_once $ROOT_PATH.'lib/semestresBO.php';

require_once $ROOT_PATH."persistencia/turmasDAO.php";

seg_proteger(false);

// Usado apenas nas telas do coordenador.
$autenticacaoBO = new AutenticacaoBO();
$autenticacaoBO->verificarCoordenador();

if(isset($_POST['codigoSemestre'])) {
	$codigo_semestre = $_POST['codigoSemestre'];
} else {
	$codigo_semestre = null;
}

if(isset($_POST['codigoDisciplina'])) {
	$codigo_disciplina = $_POST['codigoDisciplina'];
} else {
	$codigo_disciplina = null;
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

	$lista_turmas = $turmasDAO->recuperaDeFiltro($filtro,$ordem);

	if(count($lista_turmas)) {
		echo '<option value="0"></option>';
		foreach($lista_turmas as $turma)
		{
         	echo '<option value="'.h($turma->codigo).'">'.h($turma->disciplina_descricao.' - '.$turma->descricao).'</option>';
		}
	} else {
		echo '';
	}
} else {
	echo '';
}
?>