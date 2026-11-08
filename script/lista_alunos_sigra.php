<?php
// Script de linha de comando: não pode ser executado pela web.
if (PHP_SAPI !== 'cli') {
	header('HTTP/1.1 404 Not Found');
	exit;
}

//if(isset($argv[1])) {
	require_once '../conf/default.php';

	require_once $ROOT_PATH.'lib/alunosBO.php';
	require_once $ROOT_PATH.'lib/turmasBO.php';
	require_once $ROOT_PATH.'lib/semestresBO.php';
	require_once $ROOT_PATH.'lib/composicao_turmasBO.php';
	require_once $ROOT_PATH.'lib/gruposBO.php';
	require_once $ROOT_PATH.'lib/moodleBO.php';

	$alunosBO = new AlunosBO();
	$turmasBO = new TurmasBO();
	$semestresBO = new SemestresBO();
	$composicao_turmasBO = new ComposicaoTurmasBO();
	$moodleBO = new MoodleBO();

	try{
		//$arquivo = fopen($argv[1], "r");
		//$arquivo = fopen("/1_BKP.txt", "r");
		//$arquivo = fopen("/2.txt", "r");
		//$arquivo = fopen("/3.txt", "r");
		$arquivo = fopen("/scripts/emural/a.txt", "r");
	} catch (Exception $e) {
		print_r($e);
		exit;
	}

	$lista_turmas_arquivo = array();

	$semestre = $semestresBO->retornaUltimoSemestre();

	$lista_turmas = $turmasBO->retornaArrayPorSemestre($semestre);

	// Verifica, antes de alterar qualquer matrícula, se todas as turmas do
	// arquivo (linhas INFO:ano/semestre:...) são do semestre atual do sistema.
	$numero_linha = 0;
	while(!feof($arquivo))
	{
		$linha = fgets($arquivo);
		$numero_linha++;

		if(strlen($linha)) {
			$dados = explode(":", $linha);

			if(count($dados) > 1 && strcmp($dados[0],"INFO") == 0) {
				$ano_semestre = explode("/", trim($dados[1]));
				$ano_arquivo = isset($ano_semestre[0]) ? trim($ano_semestre[0]) : "";
				$semestre_arquivo = isset($ano_semestre[1]) ? trim($ano_semestre[1]) : "";

				if(strcmp($ano_arquivo, (string) $semestre->ano) != 0 || strcmp($semestre_arquivo, (string) $semestre->semestre) != 0) {
					echo "Erro: a linha ".$numero_linha." do arquivo é do semestre ".$ano_arquivo."/".$semestre_arquivo
						.", mas o semestre atual do sistema é ".$semestre->ano."/".$semestre->semestre.". Nenhuma alteração foi feita.\n";
					fclose($arquivo);
					exit(1);
				}
			}
		}
	}
	rewind($arquivo);

	while(!feof($arquivo))
	{
		$linha = fgets($arquivo);


		if(strlen($linha)) {
			$dados = explode(":", $linha);
			if(count($dados) > 1) {
				if(strcmp($dados[0],"INFO") == 0) {
					$data = explode("/", $dados[1]);

					$turma = new stdClass();
					$turma->ano = preg_replace('/[\r\n\t\f\s\n]*$/', '', $data[0]);
					$turma->semestre = preg_replace('/[\r\n\t\f\s\n]*$/', '', $data[1]);
					$turma->codigo_cpd = preg_replace('/[\r\n\t\f\s\n]*$/', '', $dados[4]);
					$turma->descricao = preg_replace('/[\r\n\t\f\s\n]*$/', '', $dados[6]);

					$lista_turmas_arquivo[] = $turma;

					unset($turma);
				} else {
					$aluno = new stdClass();
					$aluno->matricula = preg_replace('/[\r\n\t\f\s\n]*$/', '', $dados[0]);
					$aluno->opcao_curso = preg_replace('/[\r\n\t\f\s\n]*$/', '', $dados[1]);
					$aluno->nome = preg_replace('/[\r\n\t\f\s\n]*$/', '', $dados[2]);

					$lista_turmas_arquivo[count($lista_turmas_arquivo) - 1]->alunos[$aluno->matricula] = $aluno;

					unset($aluno);
				}
			}
		}

		if(count($lista_turmas_arquivo) > 1) {
			$turma_arquivo = $lista_turmas_arquivo[0];

			if(isset($lista_turmas[$turma_arquivo->codigo_cpd.$turma_arquivo->descricao])) {
				$turma = $lista_turmas[$turma_arquivo->codigo_cpd.$turma_arquivo->descricao];


				$lista_alunos = $composicao_turmasBO->retornaArrayPorTurma($turma);

				foreach($turma_arquivo->alunos as $key => $aluno_arquivo)
				{

					if(isset($lista_alunos[$key])) {
						$aluno = $alunosBO->retornaPorMatricula($aluno_arquivo->matricula);

						$grupo = null;
						if (strlen($turma->grupo_codigo_moodle)) {
							$grupoBO = new GruposBO();
							$grupo = $grupoBO->retornaPorCodigo($turma->grupo_codigo);
						}

						$moodleBO->cursoMatricular($turma, $aluno, $grupo);

						echo"<pre>:";print_r($aluno);echo":</pre><br><br>";
						unset($lista_alunos[$key]);
						unset($turma->alunos[$key]);
					} else {
						$aluno = $alunosBO->retornaPorMatricula($aluno_arquivo->matricula);

						if($aluno === null) {
							$aluno = $alunosBO->inserir($aluno_arquivo);
						}

						$grupo = null;
						if (strlen($turma->grupo_codigo_moodle)) {
							$grupoBO = new GruposBO();
							$grupo = $grupoBO->retornaPorCodigo($turma->grupo_codigo);
						}

						$composicao_turmasBO->matricularAlunoTurma($aluno, $turma);
						$moodleBO->cursoMatricular($turma, $aluno, $grupo);
						
					}
				}
				if(count($lista_alunos)) {
					foreach($lista_alunos as $aluno)
					{
						$grupo = null;
						if (strlen($turma->grupo_codigo_moodle)) {
							$grupoBO = new GruposBO();
							$grupo = $grupoBO->retornaPorCodigo($turma->grupo_codigo);
						}

						$composicao_turmasBO->desmatricularAlunoTurma($aluno->codigo_aluno, $turma);
						$moodleBO->cursoDesmatricular($turma, $aluno, $grupo);
					}
				}
			}
	        $turma = $lista_turmas_arquivo[1];
	        unset($lista_turmas_arquivo);
	        $lista_turmas_arquivo[] = $turma;
	        unset($turma);
		}
	}

	if(count($lista_turmas_arquivo) > 0) {
		$turma_arquivo = $lista_turmas_arquivo[0];

		if(isset($lista_turmas[$turma_arquivo->codigo_cpd.$turma_arquivo->descricao])) {
			$turma = $lista_turmas[$turma_arquivo->codigo_cpd.$turma_arquivo->descricao];

			$lista_alunos = $composicao_turmasBO->retornaArrayPorTurma($turma);

			foreach($turma_arquivo->alunos as $key => $aluno_arquivo)
			{
				if(isset($lista_alunos[$key])) {
					$aluno = $alunosBO->retornaPorMatricula($aluno_arquivo->matricula);
					echo"<pre>";print_r($aluno);echo"</pre><br><br>";
					$grupo = null;
					if (strlen($turma->grupo_codigo_moodle)) {
						$grupoBO = new GruposBO();
						$grupo = $grupoBO->retornaPorCodigo($turma->grupo_codigo);
					}

					$moodleBO->cursoMatricular($turma, $aluno, $grupo);

					unset($lista_alunos[$key]);
					unset($turma->alunos[$key]);
				} else {
					$aluno = $alunosBO->retornaPorMatricula($aluno_arquivo->matricula);

					if($aluno === null) {
						$aluno = $alunosBO->inserir($aluno_arquivo);
					}

					$grupo = null;
					if (strlen($turma->grupo_codigo_moodle)) {
						$grupoBO = new GruposBO();
						$grupo = $grupoBO->retornaPorCodigo($turma->grupo_codigo);
					}

					$composicao_turmasBO->matricularAlunoTurma($aluno,$turma);
					$moodleBO->cursoMatricular($turma, $aluno, $grupo);
				}
			}
			if(count($lista_alunos)) {
				
				foreach($lista_alunos as $aluno)
				{
					$grupo = null;
					if (strlen($turma->grupo_codigo_moodle)) {
						$grupoBO = new GruposBO();
						$grupo = $grupoBO->retornaPorCodigo($turma->grupo_codigo);
					}

					$composicao_turmasBO->desmatricularAlunoTurma($aluno->codigo_aluno, $turma);
					$moodleBO->cursoDesmatricular($turma, $aluno, $grupo);
				}
			}
		}
	}
//}
?>
