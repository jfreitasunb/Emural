<?php
require_once '../conf/default.php';
require_once $ROOT_PATH.'lib/moodleBO.php';

if (isset($_GET['f'])) {
	$funcao = $_GET['f'];

	$moodleBO = new MoodleBO();

	echo "<pre>";

	switch ($funcao) {
		case "usuario_cadastrar":
			require_once $ROOT_PATH.'lib/pessoasBO.php';

			$pessoa_codigo = $_GET['usuario'];

			$pessoasBO = new PessoasBO();

			$pessoa = $pessoasBO->retornaPorCodigo($pessoa_codigo);

			$moodleBO->usuarioCadastrar($pessoa);

		break;

		case "curso_criar":
			require_once $ROOT_PATH.'lib/turmasBO.php';

			$turma_codigo = $_GET['turma'];

			$turmasBO = new TurmasBO();

			$turma = $turmasBO->retornaPorCodigo($turma_codigo);

			$moodleBO->cursoCriar($turma);

		break;

		case "curso_matricular":
			require_once $ROOT_PATH.'lib/turmasBO.php';
			require_once $ROOT_PATH.'lib/pessoasBO.php';

			$turma_codigo = $_GET['turma'];
			$pessoa_codigo = $_GET['usuario'];

			$turmasBO = new TurmasBO();
			$pessoasBO = new PessoasBO();

			$turma = $turmasBO->retornaPorCodigo($turma_codigo);
			$pessoa = $pessoasBO->retornaPorCodigo($pessoa_codigo);

			$moodleBO->cursoMatricular($turma, $pessoa);

		break;

		case "teste":
			$pessoa = new stdClass();
			$pessoa->codigo_moodle = 3;
			$pessoa->tipo = "professor";

			$turma = new stdClass();
			$turma->codigo_moodle = 2;

			$moodleBO->cursoDesmatricular($turma, $pessoa);

		break;

		default:
			;
		break;
	}
	echo "</pre>";
}
?>