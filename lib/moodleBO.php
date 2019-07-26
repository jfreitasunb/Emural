<?php

require_once $ROOT_PATH.'lib/curl.php';
require_once $ROOT_PATH.'lib/pessoasBO.php';
require_once $ROOT_PATH.'lib/turmasBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';
require_once $ROOT_PATH.'lib/gruposBO.php';

class MoodleBO
{
	private $url;
	private $token;
	private $servicos;
	private $formato_resposta;

	function __construct()
	{
		GLOBAL $URL_MOODLE, $TOKEN_MOODLE, $SERVICOS_MOODLE;

		$this->url = $URL_MOODLE;
		$this->token = $TOKEN_MOODLE;
		$this->servicos = $SERVICOS_MOODLE;
		$this->formato_resposta = "json";
	}

	public function usuarioCadastrar(&$pessoa)
	{
		if (!isset($pessoa->codigo_moodle) || !strlen($pessoa->codigo_moodle)) {
			$nome_array = explode(' ', $pessoa->nome);
			$primeiroNome = $nome_array[0];
			if (count($nome_array) > 1) {
				$ultimoNome = $nome_array[count($nome_array) - 1];
			} else {
				$ultimoNome = " ";
			}

			$usuario = new stdClass();
			$usuario->username = $pessoa->usuario;
			$usuario->password = 'As12345.';
			$usuario->firstname = $primeiroNome;
			$usuario->lastname = $ultimoNome;
			$usuario->email = strlen($pessoa->email) ? $pessoa->email : $pessoa->usuario."@mat.unb.br";
			$usuario->auth = 'emural';
			$usuario->lang = 'pt_br';
			$usuario->country = 'BR';

			$usuarios = array($usuario);

			$parametro = array('users' => $usuarios);

			$servico = $this->servicos["usuario_cadastrar"];

			$resposta = $this->executarRequisicao($servico, $parametro);
			if (is_array($resposta)) {
				$pessoasBO = new PessoasBO();

				$pessoa_moodle = $resposta[0];

				$pessoasBO->alteraCodigoMoodle($pessoa, $pessoa_moodle->id);
			} elseif (is_object($resposta)) {
//echo"<pre>";var_dump($usuario);echo"</pre><br><br>";//Se tiver problema descomentar essa linha
//echo"<pre>";print_r($resposta);echo"</pre><br><br>";
				throw new Exception($resposta->exception."\n * ".$resposta->message);
			}
		}
	}

	public function usuarioAtualizar($pessoa)
	{
		if (isset($pessoa->codigo_moodle) && strlen($pessoa->codigo_moodle)) {
			$nome_array = explode(' ', $pessoa->nome);
			$primeiroNome = $nome_array[0];
			if (count($nome_array) > 1) {
				$ultimoNome = $nome_array[count($nome_array) - 1];
			} else {
				$ultimoNome = " ";
			}

			$usuario = new stdClass();
			$usuario->id = $pessoa->codigo_moodle;
			$usuario->firstname = $primeiroNome;
			$usuario->lastname = $ultimoNome;
			$usuario->email = strlen($pessoa->email) ? $pessoa->email : $pessoa->usuario."@mat.unb.br";

			$usuarios = array($usuario);

			$parametro = array('users' => $usuarios);

			$servico = $this->servicos["usuario_atualizar"];

			$resposta = $this->executarRequisicao($servico, $parametro);

			if (is_object($resposta)) {
				throw new Exception($resposta->exception."\n * ".$resposta->message);
			}
		}
	}

	public function cursoCriar(&$turma, $dividido = FALSE)
	{
		$curso = new stdClass();

		if (!isset($turma->disciplina_descricao)) {
			$disciplinasBO = new DisciplinasBO();

			$disciplina = $disciplinasBO->retornaPorCodigo($turma->disciplina);

			$turma->disciplina_descricao = $disciplina->descricao;
		}

		//groupmode 0 = no group, 1 = separate, 2 = visible.

		if ($dividido) {
			$curso->fullname = $turma->disciplina_descricao;
			$curso->shortname = $turma->disciplina_descricao;
			$curso->groupmode = '1'; //separate
		} else {
			$curso->fullname = $turma->disciplina_descricao." - ".$turma->descricao;
			$curso->shortname = $turma->disciplina_descricao." - ".$turma->descricao;
			$curso->groupmode = '0'; //no group
		}

		$curso->categoryid = '1'; //TODO definir como vai ser a categoria.
		$curso->visible = 0;

		$cursos = array($curso);

		$parametro = array('courses' => $cursos);

		$servico = $this->servicos["curso_criar"];

		$resposta = $this->executarRequisicao($servico, $parametro);

		if (is_array($resposta)) {
			$turmasBO = new TurmasBO();

			$turma_moodle = $resposta[0];

			$turmasBO->alteraCodigoMoodle($turma, $turma_moodle->id);
		} elseif (is_object($resposta)) {
			throw new Exception($resposta->exception."\n".$resposta->message);
		}
	}

	public function cursoMatricular($turma, $pessoa, $grupo = null)
	{
		$this->matricular_desmatricular($turma, $pessoa, false);

		if ($grupo !== null) {
			$this->grupoMatricular($grupo, $pessoa);
		}
	}

	public function cursoDesmatricular($turma, $pessoa, $grupo = null)
	{
		if ($grupo !== null) {
			$this->grupoDesmatricular($grupo, $pessoa);
		}

		$this->matricular_desmatricular($turma, $pessoa, true);
	}

	public function grupoCriar($grupo)
	{
		$group = new stdClass();
		$group->courseid = $grupo->turma_codigo_moodle;
		$group->name = $grupo->disciplina_descricao." - ".$grupo->turma_descricao; //nome
		$group->description = $grupo->disciplina_descricao." - ".$grupo->turma_descricao; //descricao do grupo
		$group->descriptionformat = 1;

		$groups = array($group);

		$parametro = array('groups' => $groups);

		$servico = $this->servicos["grupo_criar"];

		$resposta = $this->executarRequisicao($servico, $parametro);

		if (is_array($resposta)) {
			$gruposBO = new GruposBO();

			$grupo_moodle = $resposta[0];

			$gruposBO->alteraCodigoMoodle($grupo, $grupo_moodle->id);
		} elseif (is_object($resposta)) {
			print_r($group);
			throw new Exception($resposta->exception."\n".$resposta->message);
		}
	}

	public function grupoMatricular($grupo, $pessoa)
	{
		$membro = new stdClass();
		$membro->groupid = $grupo->codigo_moodle;
		$membro->userid = $pessoa->codigo_moodle;

		$membros = array($membro);

		$parametro = array('members' => $membros);

		$servico = $this->servicos["grupo_matricular"];

		$resposta = $this->executarRequisicao($servico, $parametro);

		print_r($resposta);
	}

	public function grupoDesmatricular($grupo, $pessoa)
	{
		$membro = new stdClass();
		$membro->groupid = $grupo->codigo_moodle;
		$membro->userid = $pessoa->codigo_moodle;

		$membros = array($membro);

		$parametro = array('members' => $membros);

		$servico = $this->servicos["grupo_desmatricular"];

		$resposta = $this->executarRequisicao($servico, $parametro);

		print_r($resposta);
	}

	private function matricular_desmatricular($turma, $pessoa, $remover_matricula = false)
	{
		$matricula = new stdClass();
		$matricula->courseid = $turma->codigo_moodle;

		if ($remover_matricula) {
			$matricula->suspend = 1;
		}

		$this->usuarioCadastrar($pessoa);

		$matricula->userid = $pessoa->codigo_moodle;

		$tipo;
		switch ($pessoa->tipo) {
			case "professor":
				$tipo = "3";
			break;

			case "aluno":
				$tipo = "5";
			break;

			default:
				$tipo = "6";
			break;
		}

		$matricula->roleid = $tipo;

		$matriculas = array($matricula);

		$parametro = array('enrolments' => $matriculas);

		$servico = $this->servicos["curso_matricular"];

		$resposta = $this->executarRequisicao($servico, $parametro);

		if (is_object($resposta)) {
			throw new Exception($resposta->exception."\n".$resposta->message);
		}

	}

	private function executarRequisicao($servico, $parametro)
	{
		$serverurl = $this->url . '/webservice/rest/server.php' . '?wstoken=' . $this->token . '&wsfunction=' . $servico;
		$curl = new curl;
		$restFormat = '&moodlewsrestformat='.$this->formato_resposta;
		$resp = $curl->post($serverurl . $restFormat, $parametro);

		$obj = json_decode($resp);

		return $obj;
	}
}
?>
