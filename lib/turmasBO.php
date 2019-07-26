<?php

require_once $ROOT_PATH."persistencia/turmasDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/avaliacoesBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';
require_once $ROOT_PATH.'lib/linkBO.php';
require_once $ROOT_PATH.'lib/semestresBO.php';
require_once $ROOT_PATH.'lib/SIBO.php';
require_once $ROOT_PATH.'lib/disciplinasBO.php';
require_once $ROOT_PATH.'lib/composicao_turmasBO.php';
require_once $ROOT_PATH.'lib/calcular_mediaBO.php';
require_once $ROOT_PATH.'lib/notasBO.php';
require_once $ROOT_PATH.'lib/gruposBO.php';
require_once $ROOT_PATH.'lib/moodleBO.php';

class TurmasBO extends BO
{
	function __construct()
	{
		$this->DAO = new TurmasDAO();
	}

	public function preencherMenuProfessor($tpl,$professor,$ano,$semestre)
	{
		$avaliacoesBO = new AvaliacoesBO();
		$linkBO = new LinkBO();

		$filtro["professor"] = $professor->codigo;
		$filtro["ano"] = $ano;
		$filtro["semestre"] = $semestre;

		$ordem["disciplina_descricao"] = "ASC";
		$ordem["descricao"] = "ASC";

		$lista_turmas = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		$turma_preenche = null;
		foreach($lista_turmas as $turma)
		{
			unset($turma_preenche);
			$turma_preenche = new stdClass();
			$turma_preenche->disciplina_descricao = $turma->disciplina_descricao;
			if(strlen($turma_preenche->disciplina_descricao) > 12) {
				$turma_preenche->disciplina_descricao = substr($turma_preenche->disciplina_descricao,0,12);
			}
			$turma_preenche->descricao = $turma->descricao;
			if(strlen($turma->compisicao_nota)) {
				$turma_preenche->reconfiguracao_link = $linkBO->getTurmaConfiguracao($turma);
			} else {
				$turma_preenche->configuracao_link = $linkBO->getTurmaConfiguracao($turma);
			}
			$turma_preenche->index_link = $linkBO->getTurma($turma);
			$turma_preenche->avisos_link = $linkBO->getAvisos($turma);

			if($avaliacoesBO->preencherTurmaMenu($tpl,$turma)) {
				$turma_preenche->medias_mencoes_link = $linkBO->getMediaMencao($turma);
				$turma_preenche->monitores_link = $linkBO->getMonitores($turma);
			}

			$this->preencherObjeto($tpl,$turma_preenche,"turma_","adicionar_turma");
		}
	}


	public function atualizarCalculoMedia($composicao_nota, $turma)
	{
		$filtro["codigo"] = $turma->codigo;
		$campos["compisicao_nota"] = $composicao_nota;

		$this->DAO->updateCamposDeFiltro($campos,$filtro);
	}

	public function atualizarCalculoMediaPonderada($pesos,$turma)
	{
		$composicao_nota = '(';
		foreach($pesos as $key => $value)
		{
			$composicao_nota .= '$this->peso("'.$key.'",'.$value.') + ';
		}
		$composicao_nota = substr($composicao_nota,0,strlen($composicao_nota)-3).')/$this->pesoTotal()';

		$this->atualizarCalculoMedia($composicao_nota, $turma);
	}


	public function preencherNotasAluno($tpl,$aluno,$semestre)
	{
		$notasBO = new NotasBO();

		$filtro['ctu_calu'] = $aluno->codigo;
		$filtro['semestre'] = $semestre->semestre;
		$filtro['ano'] = $semestre->ano;

		$ordem['codigo'] = "DESC";

		$lista = & $this->DAO->recuperaDeFiltroDeComposicaoTurma($filtro,$ordem);

		if(count($lista)) {
			foreach($lista as $turma)
			{
				$notas = & $notasBO->retornaNotasTurmaAluno($turma,$aluno);

				$observacoes = null;
				if(count($notas)) {
					foreach($notas as $nota)
					{
						$tpl->setVariable(array(
							'celula_titulo'  => $nota->descricao,
							'celula_corpo' => $nota->valor
						));
						$tpl->parse("adicionar_celula_titulo");
						$tpl->parse("adicionar_celula_corpo");

						$observacoes[] = $nota->observacao;
					}
				}

				if(strlen($turma->media)) {
					if(strcmp($turma->exibe_media,"t") == 0) {
						$tpl->setVariable(array(
							'celula_titulo'  => "Média",
							'celula_corpo' => $turma->media
						));
						$tpl->parse("adicionar_celula_titulo");
						$tpl->parse("adicionar_celula_corpo");
					}

					if(strcmp($turma->exibe_mencao,"t") == 0) {
						$tpl->setVariable(array(
							'celula_titulo'  => "Menção",
							'celula_corpo' => $turma->mencao
						));
						$tpl->parse("adicionar_celula_titulo");
						$tpl->parse("adicionar_celula_corpo");
					}
				}

				if($observacoes !== null) {
					$tpl->parse("adicionar_linha");

					foreach($observacoes as $observacao)
					{
						$tpl->setVariable(array(
							'celula_corpo' => $observacao." "
						));
						$tpl->parse("adicionar_celula_corpo");
					}
				}

				$tpl->setVariable(array(
					'disciplina_nome'  => $turma->disciplina_descricao
				));
				$tpl->parse("adicionar_disciplina");
			}
		}
	}


	public function retornaPorCodigoSemestreAtual($codigo,$semestre)
	{
		$filtro["codigo"] = $codigo;
		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;

		$obj_ret = & $this->DAO->recuperaDeFiltro($filtro);

		if(count($obj_ret)) {
			$retorno = & $obj_ret[0];
		} else {
			$retorno = null;
		}

		return $retorno;
	}


	public function retornaPorCodigoExcetoSemestreAtual($codigo,$semestre)
	{
		$filtro["codigo"] = $codigo;

		$obj_ret = & $this->DAO->recuperaDeFiltro($filtro);

		if(count($obj_ret)) {
			$retorno = & $obj_ret[0];
			if($retorno->ano == $semestre->ano && $retorno->semestre == $semestre->semestre) {
				$retorno = null;
			}
		} else {
			$retorno = null;
		}

		return $retorno;
	}


	public function retornaPorSemestre($semestre)
	{
		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;

		$ordem['disciplina_descricao'] = "ASC";
		$ordem['descricao'] = "ASC";

		$lista = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		if(count($lista)) {
			$retorno = & $lista;
		} else {
			$retorno = null;
		}

		return $retorno;
	}


	public function preencherExibirMediaMencao($tpl,$turma)
	{
		$turma_preencher = null;

		if(strcmp($turma->exibe_media,"t") == 0) {
			$turma_preencher->medias = "checked";
		}
		if(strcmp($turma->exibe_mencao,"t") == 0) {
			$turma_preencher->mencoes = "checked";
		}

		$this->preencherObjeto($tpl,$turma_preencher,"turma_exibe_");
	}


	public function atualizarExibirMediaMencao($turma,$turma_alterar)
	{
		$filtro["codigo"] = $turma->codigo;

		$this->DAO->updateCamposDeFiltro($turma_alterar,$filtro);
	}


	public function preencheComboMesmoSemestre($tpl, $turma_selecionada = null)
	{
		if($turma_selecionada !== null) {
			$lista = & $this->retornaPorSemestre($turma_selecionada);

			if(count($lista)) {
				foreach($lista as $turma)
				{
					$preencher = new stdClass();
					$preencher->codigo = $turma->codigo;
					$preencher->descricao = $turma->disciplina_descricao." - ".$turma->descricao;

					if($turma_selecionada != null &&
					   isset($turma_selecionada->codigo) &&
					   $turma->codigo == $turma_selecionada->codigo) {
						$preencher->selected = 'selected="selected"';
					} else {
						$preencher->selected = "";
					}

					$this->preencherObjeto($tpl,$preencher,"combo_turma_","adicionar_combo_turma");
				}
			}
		}
	}


	public function retornaArrayPorSemestre($semestre,$professor = null)
	{
		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;
		if($professor !== null) {
			$filtro["professor"] = $professor->codigo;
		}

		$ordem["disciplina_descricao"] = "ASC";
		$ordem["descricao"] = "ASC";

		$lista_obj = & $this->DAO->recuperaDeFiltroComGrupos($filtro,$ordem);


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


	public function preencheComboListaAlunos($tpl,$dados,$semestre)
	{
		if($dados !== null) {
			$filtro["ano"] = $semestre->ano;
			$filtro["semestre"] = $semestre->semestre;
			$filtro["disciplina"] = $dados->disciplina;

			$ordem["disciplina_descricao"] = "ASC";
			$ordem["descricao"] = "ASC";

			$lista = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

			if(count($lista)) {
				foreach($lista as $turma)
				{
					$preencher = new stdClass();
					$preencher->codigo = $turma->codigo;
					$preencher->descricao = $turma->disciplina_descricao." - ".$turma->descricao;

					if($turma->codigo == $dados->turma) {
						$preencher->selected = 'selected="selected"';
					} else {
						$preencher->selected = "";
					}

					$this->preencherObjeto($tpl,$preencher,"combo_turma_","adicionar_combo_turma");
				}
			}
		}
	}


	public function atualizacaoTurmasProfessor($professor)
	{
		global $DEPARTAMENTO;

		$semestresBO = new SemestresBO();
		$disciplinasBO = new DisciplinasBO();
		$siBO = new SIBO();

		$semestre = $semestresBO->retornaUltimoSemestre();

		$lista_turmas = $this->retornaArrayPorSemestre($semestre,$professor);
		$lista_turmas_si = $siBO->retornaArrayTurmasPorSemestre($semestre,$professor);
		$lista_disciplinas = $disciplinasBO->retornaArray();

		if(count($lista_turmas_si)) {
			foreach($lista_turmas_si as $key => $turma_si)
			{
				if(isset($lista_turmas[$key])) {
					unset($lista_turmas[$key]);
					unset($lista_turmas_si[$key]);
				} else {
					if(!isset($lista_disciplinas[$turma_si->codigo_cpd])) {
						$disciplina->codigo_cpd = $turma_si->codigo_cpd;
						$disciplina->descricao = $turma_si->disciplina_descricao;
						$disciplina->creditos = $turma_si->creditos;
						$disciplina->departamento = $DEPARTAMENTO;

						$disciplina = $disciplinasBO->cadastrar($disciplina);

						$lista_disciplinas[$turma_si->codigo_cpd] = $disciplina;

						unset($disciplina);
					}
					$turma = new stdClass();
					$turma->descricao = $turma_si->descricao;
					$turma->periodo = $turma_si->periodo;
				//	$turma->sala = $turma_si->sala;
					$turma->professor = $professor->codigo;
					$turma->semestre = $turma_si->semestre;
					$turma->ano = $turma_si->ano;
					$turma->disciplina = $lista_disciplinas[$turma_si->codigo_cpd]->codigo;

					$this->cadastrar($turma,$professor);
				}
			}
		}
		if(count($lista_turmas)) {
			$professorBO = new ProfessoresBO();
			foreach($lista_turmas as $key => $turma)
			{
				$turma_si = $siBO->retornaTurma($turma);
				$professor_novo = $professorBO->retornaPorCodigoSI($turma_si->professor);

				$this->atualizacaoTurmasProfessor($professor_novo);
			}
		}
	}


	public function atualizacaoTurmasInicioSemestre($semestre, $disciplinas_unidas_formulario = null)
	{
		$semestresBO = new SemestresBO();
		$disciplinasBO = new DisciplinasBO();
		$siBO = new SIBO();
		$professorBO = new ProfessoresBO();

		$lista_turmas = $this->retornaArrayPorSemestre($semestre);
		$lista_turmas_si = $siBO->retornaArrayTurmasPorSemestre($semestre);
		$lista_disciplinas = $disciplinasBO->retornaArray();

		$disciplinas_unidas = null;
		$turmas_juntas = $this->listaDisciplinasJuntas($semestre, $disciplinas_unidas_formulario, $disciplinas_unidas);

		if(count($lista_turmas_si)) {
			foreach($lista_turmas_si as $key => $turma_si)
			{
				if(isset($lista_turmas[$key])) {
					unset($lista_turmas[$key]);
					unset($lista_turmas_si[$key]);
				} else {
					if(!isset($lista_disciplinas[$turma_si->codigo_cpd])) {
						$disciplina = new stdClass();
						$disciplina->codigo_cpd = $turma_si->codigo_cpd;
						$disciplina->descricao = $turma_si->disciplina_descricao;
						$disciplina->creditos = $turma_si->creditos;

						$disciplina = $disciplinasBO->cadastrar($disciplina);

						$lista_disciplinas[$turma_si->codigo_cpd] = $disciplina;

						unset($disciplina);
					}
					$professor = $professorBO->retornaPorCodigoSI($turma_si->professor);

					$turma = new stdClass();
					$turma->descricao = $turma_si->descricao;
					$turma->periodo = $turma_si->periodo;
				//	$turma->sala = $turma_si->sala;
					$turma->professor = $professor->codigo;
					$turma->semestre = $turma_si->semestre;
					$turma->ano = $turma_si->ano;
					$turma->disciplina = $lista_disciplinas[$turma_si->codigo_cpd]->codigo;

					if (isset($turmas_juntas[$turma_si->codigo_cpd])) {
						$turma_moodle_codigo = & $turmas_juntas[$turma_si->codigo_cpd];

						$this->cadastrar($turma, $professor, $turma_moodle_codigo);

						if (isset($disciplinas_unidas[$turma_si->codigo_cpd])) {
							$this->propagarCodigoMoodleDisciplinasUnidas($turmas_juntas, $disciplinas_unidas, $turma_si->codigo_cpd);
						}
					} else {
						$this->cadastrar($turma, $professor);
					}
				}
			}
		}
	}


	public function cadastrar($turma, $professor, &$turma_moodle_codigo = null)
	{
		if($turma !== null) {
			$turma->descricao = preg_replace('/[\r\n\t\f\s\n ]*$/', '', $turma->descricao);
			$return =  $this->DAO->inserir($turma);

			$moodleBO = new MoodleBO();

			$grupo = null;

			if ($turma_moodle_codigo !== null) {
				if ($turma_moodle_codigo != 0) {
					$this->alteraCodigoMoodle($turma, $turma_moodle_codigo);
				} else {
					$moodleBO->cursoCriar($turma, true);

					$turma_moodle_codigo = $turma->codigo_moodle;
				}

				$gruposBO = new GruposBO();

				$grupo = $gruposBO->cadastrar($turma);
			} else {
				$moodleBO->cursoCriar($turma);
			}

			$moodleBO->cursoMatricular($turma, $professor, $grupo);
		} else {
			$return = null;
		}
		return $return;
	}


	private function listaDisciplinasJuntas($semestre, $disciplinas_unidas_formulario = null, &$disciplinas_unidas = null)
	{
		$siBO = new SIBO();
		$gruposBO = new GruposBO();

		$lista_disciplinas_magistrais = $siBO->retornaArrayDisciplinasMagistrais($semestre);
		$lista_turmas_juntas = $gruposBO->retornaDisciplinasQuePossuemGrupoNoSemestre($semestre);

		$turmas_juntas = null;
		if ($lista_turmas_juntas == null) {
			$turmas_juntas = Array();
		} else {
			foreach($lista_turmas_juntas as $disc)
			{
				$turmas_juntas[$disc->codigo_cpd] = $disc->codigo_moodle;
			}
		}

		if ($lista_disciplinas_magistrais !== null) {
			foreach($lista_disciplinas_magistrais as $disc)
			{
				if (!isset($turmas_juntas[$disc->codigo_cpd])) {
					$turmas_juntas[$disc->codigo_cpd] = 0;
				}
			}
		}

		if ($disciplinas_unidas_formulario !== null) {
			$disciplinas_unidas = Array();
			foreach($disciplinas_unidas_formulario as $key => $value)
			{
				if (!isset($turmas_juntas[$key])) {
					$turmas_juntas[$key] = 0;
				}

				if (is_array($value)) {
					$disciplinas_unidas[$key] = $disciplinas_unidas_formulario[$key];
				}
			}
		}

		return $turmas_juntas;
	}


	private function propagarCodigoMoodleDisciplinasUnidas(&$turmas_juntas, $disciplinas_unidas, $cod_cpd) {
		foreach($disciplinas_unidas[$cod_cpd] as $key => $value)
		{
			if (strcmp($turmas_juntas[$key], "0") == 0) {
				$turmas_juntas[$key] = $turmas_juntas[$cod_cpd];

				$this->propagarCodigoMoodleDisciplinasUnidas($turmas_juntas, $disciplinas_unidas, $key);
			}
		}
	}


	public function removerAvaliacoes($turma)
	{
		$this->atualizarCalculoMedia("", $turma);

		$composicao_turmasBO = new ComposicaoTurmasBO();
		$avaliacoesBO = new AvaliacoesBO();

		$composicao_turmasBO->zeraMediasMencoesFaltas($turma);

		$avaliacoesBO->removerAvaliacoes($turma);
	}


	public function preencheTabelaRelatorioListaAlunos($tpl,$dados,$semestre)
	{
		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;
		$filtro["disciplina"] = $dados->disciplina;
		if($dados->turma !== null) {
			$filtro["codigo"] = $dados->turma;
		}

		$ordem["disciplina_descricao"] = "ASC";
		$ordem["descricao"] = "ASC";

		$lista = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		if(count($lista)) {
			$composicao_turmasBO = new ComposicaoTurmasBO();

			$item->titulo = "Matrícula";
			$header[] = $item;
			unset($item);

			$item->titulo = "Nome";
			$header[] = $item;
			unset($item);

			$item->titulo = "Menção";
			$header[] = $item;
			unset($item);

			$item->titulo = "% de Faltas";
			$header[] = $item;
			unset($item);

			foreach($lista as $turma)
			{
				$this->preencherLista($tpl,$header,"celula_","adicionar_celula_titulo");

				$lista_alunos = $composicao_turmasBO->retornaAlunosMatriculados($turma);

				foreach($lista_alunos as $aluno)
				{
					$valido = true;
					if($dados->apenas_aprovados) {
						if($aluno->mencao == "SR" || $aluno->mencao == "II" || $aluno->mencao == "MI") {
							$valido = false;
						}
					}

					if($valido) {
						$item->corpo = $aluno->matricula;
						$linha[] = $item;
						unset($item);

						$item->corpo = $aluno->nome;
						$linha[] = $item;
						unset($item);

						$item->corpo = $aluno->mencao;
						$linha[] = $item;
						unset($item);

						$item->corpo = $aluno->porcentagem_faltas."%";
						$linha[] = $item;
						unset($item);

						$this->preencherLista($tpl,$linha,"celula_","adicionar_celula_corpo","adicionar_linha");
						unset($linha);
					}
				}
				$preencher->nome = $turma->disciplina_descricao." - ".$turma->descricao;
				$this->preencherObjeto($tpl,$preencher,"disciplina_","adicionar_disciplina");
			}

			return true;
		} else {
			return false;
		}
	}


	public function preencheTabelaRelatorioReprovadosDisciplina($tpl,$dados,$semestre)
	{
		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;
		$filtro["disciplina"] = $dados->disciplina;

		$ordem["disciplina_descricao"] = "ASC";
		$ordem["descricao"] = "ASC";

		$lista_turmas = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		$total = array();
		$reprovados = array();

		if(count($lista_turmas)) {
			$composicao_turmasBO = new ComposicaoTurmasBO();

			$item->titulo = "Opção de Curso";
			$header[] = $item;
			unset($item);

			$item->titulo = "Número Alunos";
			$header[] = $item;
			unset($item);

			$item->titulo = "Possiveis Reprovados";
			$header[] = $item;
			unset($item);

			$item->titulo = "% de Possiveis Reprovados";
			$header[] = $item;
			unset($item);

			$item->titulo = "Observação";
			$header[] = $item;
			unset($item);

			$avaliacoesBO = new AvaliacoesBO();
			$calcular = new calcularMediaBO();
			$notasBO = new NotasBO();

			$notas = null;
			$lista_opcoes_curso = null;

			foreach($lista_turmas as $turma)
			{
				$this->preencherLista($tpl,$header,"celula_","adicionar_celula_titulo");

				$lista_avaliacoes_aplicadas = & $avaliacoesBO->retornaAvaliacoesAplicadas($turma);

				if(count($lista_avaliacoes_aplicadas)) {
					unset($notas);
					foreach($lista_avaliacoes_aplicadas as $avaliacao_aplicada)
					{
						$notas[$avaliacao_aplicada->nome_resumido] = 10;
					}
					$media_10 = $calcular->executar($turma->compisicao_nota,$notas);
					$observacao = "";
				} else {
					$media_10 = 0;
					$observacao = "Nenhuma nota foi lançada";
				}

				$lista_alunos = $composicao_turmasBO->retornaAlunosMatriculados($turma);

				unset($lista_opcoes_curso);

				foreach($lista_alunos as $aluno)
				{
					$aluno_2->codigo = $aluno->codigo_aluno;

					$opcao_curso = $aluno->opcao_curso;

					if(!isset($lista_opcoes_curso->$opcao_curso)) {
						$lista_opcoes_curso->$opcao_curso->opcao_curso = $opcao_curso;
						$lista_opcoes_curso->$opcao_curso->total = 0;
						$lista_opcoes_curso->$opcao_curso->reprovados = 0;
						$lista_opcoes_curso->$opcao_curso->observacao = $observacao;
					}

					$lista_opcoes_curso->$opcao_curso->total++;

					if($media_10 != 0) {
						$media_aluno = $notasBO->retornaMediaMencao($turma, $aluno_2);

						if($media_aluno['media']*10/$media_10 < 5) {
							$lista_opcoes_curso->$opcao_curso->reprovados++;
						}
					}
				}

				foreach($lista_opcoes_curso as $opcao_curso)
				{
					$item->corpo = $opcao_curso->opcao_curso;
					$linha[] = $item;
					unset($item);

					$item->corpo = $opcao_curso->total;
					$linha[] = $item;
					unset($item);

					$item->corpo = $opcao_curso->reprovados;
					$linha[] = $item;
					unset($item);

					$item->corpo = round(($opcao_curso->reprovados*100)/($opcao_curso->total),2)."%";
					$linha[] = $item;
					unset($item);

					$item->corpo = $opcao_curso->observacao;
					$linha[] = $item;
					unset($item);

					if(!isset($total[$opcao_curso->opcao_curso])) {
						$total[$opcao_curso->opcao_curso] = 0;
					} if(!isset($reprovados[$opcao_curso->opcao_curso])) {
						$reprovados[$opcao_curso->opcao_curso] = 0;
					}
					$total[$opcao_curso->opcao_curso] += $opcao_curso->total;
					$reprovados[$opcao_curso->opcao_curso] += $opcao_curso->reprovados;

					$this->preencherLista($tpl,$linha,"celula_","adicionar_celula_corpo","adicionar_linha");
					unset($linha);
				}
				$preencher->nome = $turma->disciplina_descricao." - ".$turma->descricao;
				$this->preencherObjeto($tpl,$preencher,"disciplina_","adicionar_disciplina");
				unset($lista_opcoes_curso);
			}
		}

		if(count($lista_turmas) > 1) {
			unset($header);

			$item->titulo = "Opção de Curso";
			$header[] = $item;
			unset($item);

			$item->titulo = "Número Alunos";
			$header[] = $item;
			unset($item);

			$item->titulo = "Possiveis Reprovados";
			$header[] = $item;
			unset($item);

			$item->titulo = "% de Possiveis Reprovados";
			$header[] = $item;
			unset($item);

			$this->preencherLista($tpl,$header,"celula_","adicionar_celula_titulo");


			$todas['total'] = 0;
			$todas['reprovados'] = 0;

			foreach($total as $key => $value)
			{
				$item->corpo = $key;
				$linha[] = $item;
				unset($item);

				$item->corpo = $value;
				$linha[] = $item;
				unset($item);

				$item->corpo = $reprovados[$key];
				$linha[] = $item;
				unset($item);

				$item->corpo = round(($reprovados[$key]*100)/($value),2)."%";
				$linha[] = $item;
				unset($item);


				$this->preencherLista($tpl,$linha,"celula_","adicionar_celula_corpo","adicionar_linha");
				unset($linha);

				$todas['total'] += $value;
				$todas['reprovados'] += $reprovados[$key];
			}

			$item->corpo = "Todas";
			$linha[] = $item;
			unset($item);

			$item->corpo = $todas['total'];
			$linha[] = $item;
			unset($item);

			$item->corpo = $todas['reprovados'];
			$linha[] = $item;
			unset($item);

			$item->corpo = round(($todas['reprovados']*100)/($todas['total']),2)."%";
			$linha[] = $item;
			unset($item);


			$this->preencherLista($tpl,$linha,"celula_","adicionar_celula_corpo","adicionar_linha");
			unset($linha);

			$preencher->nome = $turma->disciplina_descricao." - Total";
			$this->preencherObjeto($tpl,$preencher,"disciplina_","adicionar_disciplina");
		}


		if(count($lista_turmas)) {
			return true;
		} else {
			return false;
		}
	}


	public function retornaArrayListaAlunos($dados)
	{
		$semestreBO = new SemestresBO();

		$semestre = & $semestreBO->retornaPorCodigo($dados->ano_semestre);

		$filtro["ano"] = $semestre->ano;
		$filtro["semestre"] = $semestre->semestre;
		$filtro["disciplina"] = $dados->disciplina;
		if($dados->turma !== null) {
			$filtro["codigo"] = $dados->turma;
		}

		$ordem["disciplina_descricao"] = "ASC";
		$ordem["descricao"] = "ASC";

		$lista = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		if(count($lista)) {
			$composicao_turmasBO = new ComposicaoTurmasBO();

			$item->titulo = "Matrícula";
			$header[] = $item;
			unset($item);

			$item->titulo = "Nome";
			$header[] = $item;
			unset($item);

			$item->titulo = "Menção";
			$header[] = $item;
			unset($item);

			$item->titulo = "% de Faltas";
			$header[] = $item;
			unset($item);

			$return = array();
			foreach($lista as $turma)
			{
				$item[] = $turma->disciplina_descricao." - ".$turma->descricao;
				$return[] = $item;
				unset($item);

				$item[] = "Matrícula";
				$item[] = "Nome";
				$item[] = "Menção";
				$item[] = "% de Faltas";
				$return[] = $item;
				unset($item);

				$lista_alunos = $composicao_turmasBO->retornaAlunosMatriculados($turma);

				foreach($lista_alunos as $aluno)
				{
					$valido = true;
					if($dados->apenas_aprovados) {
						if($aluno->mencao == "SR" || $aluno->mencao == "II" || $aluno->mencao == "MI") {
							$valido = false;
						}
					}

					if($valido) {
						$item[] = $aluno->matricula;
						$item[] = $aluno->nome;
						$item[] = $aluno->mencao;
						$item[] = $aluno->porcentagem_faltas;
						$return[] = $item;
						unset($item);
					}
				}
				$return[] = null;
			}

			return $return;
		} else {
			return null;
		}
	}


	public function alteraCodigoMoodle(&$turma, $codigo_moodle)
	{
		$campos['codigo_moodle'] = $codigo_moodle;

		$filtro['codigo'] = $turma->codigo;

		$this->DAO->updateCamposDeFiltro($campos, $filtro);

		$turma->codigo_moodle = $codigo_moodle;
	}
}
?>
