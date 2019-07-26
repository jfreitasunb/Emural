<?php

require_once $ROOT_PATH."persistencia/composicao_turmasDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/semestresBO.php';

class ComposicaoTurmasBO extends BO
{
	function __construct()
	{
		$this->DAO = new ComposicaoTurmasDAO();
	}


	public function retornaAlunosMatriculados($turma)
	{
		$filtro["turma"] = $turma->codigo;
		$filtro["status"] = "true";

		$ordem["matricula"] = "ASC";

		$lista_alunos = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		if(count($lista_alunos)) {
			return $lista_alunos;
		} else {
			return null;
		}
	}


	public function atualizaMediaMencaoFaltas($atualizar, $turma)
	{
		$filtro["turma"] = $turma->codigo;

		foreach($atualizar as $key => $value)
		{
			$filtro["aluno"] = $key;

			$campos["mencao"] = $value->mencao;
			$campos["media"] = str_replace(',','.',$value->media);
			$campos["faltas"] = $value->faltas;
			$campos["porcentagem_faltas"] = round(($value->faltas*100)/($turma->creditos*15),2);

			$this->DAO->updateCamposDeFiltro($campos,$filtro);
		}
	}


	public function preencheTabelaRelatorioPorcentagemMencoes($tpl,$dados,$semestre_inicio,$semestre_fim)
	{
		$lista = & $this->DAO->recuperaQuantidadeMencoesPorSemestrePorOpcaoCurso($semestre_inicio, $semestre_fim, $dados->disciplina, $dados->opcao_curso);

		if(count($lista)) {
			$item->titulo = "Ano";
			$header[] = $item;
			unset($item);

			$item->titulo = "Semestre";
			$header[] = $item;
			unset($item);

			$item->titulo = "SR";
			$header[] = $item;
			unset($item);

			$item->titulo = "II";
			$header[] = $item;
			unset($item);

			$item->titulo = "MI";
			$header[] = $item;
			unset($item);

			$item->titulo = "MM";
			$header[] = $item;
			unset($item);

			$item->titulo = "MS";
			$header[] = $item;
			unset($item);

			$item->titulo = "SS";
			$header[] = $item;
			unset($item);

			$this->preencherLista($tpl,$header,"celula_","adicionar_celula_titulo");

			foreach($lista as $obj)
			{
				$total = $obj->sr + $obj->ii + $obj->mi + $obj->mm + $obj->ms + $obj->ss;

				foreach($obj as $key => $value)
				{
					if($key == 'ano' || $key == 'semestre') {
						$preencher->corpo = $value;
					} else {
						$preencher->corpo = round(($value*100)/($total),2)."%";
					}

					$this->preencherObjeto($tpl,$preencher,"celula_","adicionar_celula_corpo");
				}
				$tpl->parse("adicionar_linha");
			}

			return true;
		} else {
			return false;
		}
	}


	public function retornaArrayPorcentagemMencoes($dados)
	{
		$semestresBO = new SemestresBO();

		$semestre_inicio = & $semestresBO->retornaPorCodigo($dados->inicio);
		$semestre_fim = & $semestresBO->retornaPorCodigo($dados->fim);

		$lista = & $this->DAO->recuperaQuantidadeMencoesPorSemestrePorOpcaoCurso($semestre_inicio, $semestre_fim, $dados->disciplina, $dados->opcao_curso);

		$coluna['ano'] = "Ano";
		$coluna['semestre'] = "Semestre";
		$coluna['sr'] = "SR";
		$coluna['ii'] = "II";
		$coluna['mi'] = "MI";
		$coluna['mm'] = "MM";
		$coluna['ms'] = "MS";
		$coluna['ss'] = "SS";

		$obj = null;
		foreach($lista as $linha)
		{
			$total = $linha->sr + $linha->ii + $linha->mi + $linha->mm + $linha->ms + $linha->ss;
			unset($obj);
			foreach($linha as $key => $value)
			{
				if($key == 'ano' || $key == 'semestre') {
					$obj[$coluna[$key]] = $value;
				} else {
					$obj[$coluna[$key]] = round(($value*100)/($total),2);
				}
			}
			$lista_retorno[] = $obj;
		}

		return $lista_retorno;
	}


	public function preencheGraficoRelatorioPorcentagemAprovados($tpl,$dados,$semestre_inicio,$semestre_fim)
	{
		$lista = & $this->DAO->recuperaQuantidadeMencoesPorSemestrePorOpcaoCurso($semestre_inicio, $semestre_fim, $dados->disciplina, $dados->opcao_curso);

		if(count($lista)) {
			$item->descricao = "Aprovado";
			$dados_descricao[] = $item;
			unset($item);

			$item->descricao = "Reprovado";
			$dados_descricao[] = $item;
			unset($item);

			$this->preencherLista($tpl,$dados_descricao,"dado_","adicionar_dado_descricao");

			$preencher_aprovados->descricao = "var1";
			$preencher_aprovados->valor = null;
			$preencher_reprovados->descricao = "var2";
			$preencher_reprovados->valor = null;

			$preencher_grafico->conjunto_descricao = null;
			$preencher_grafico->variaveis_entrada = "var1,var2";
			$preencher_grafico->label_eixo_x = "Período";
			$preencher_grafico->label_eixo_y = "Porcentagem";

			foreach($lista as $obj)
			{
				$total = $obj->sr + $obj->ii + $obj->mi + $obj->mm + $obj->ms + $obj->ss;
				$aprovados = $obj->mm + $obj->ms + $obj->ss;
				$reprovados = $obj->sr + $obj->ii + $obj->mi;

				$preencher_aprovados->valor .= round(($aprovados*100)/($total),2).",";
				$preencher_reprovados->valor .= round(($reprovados*100)/($total),2).",";

				$preencher_grafico->conjunto_descricao .= "\"".$obj->ano."/".$obj->semestre."\",";
			}

			$preencher_dados[] = $preencher_aprovados;
			$preencher_dados[] = $preencher_reprovados;

			$this->preencherObjeto($tpl,$preencher_grafico,"grafico_");
			$this->preencherLista($tpl,$preencher_dados,"variavel_","adicionar_variavel");

			return true;
		} else {
			return false;
		}
	}


	public function retornaArrayPorcentagemAprovados($dados)
	{
		$semestresBO = new SemestresBO();

		$semestre_inicio = & $semestresBO->retornaPorCodigo($dados->inicio);
		$semestre_fim = & $semestresBO->retornaPorCodigo($dados->fim);

		$lista = & $this->DAO->recuperaQuantidadeMencoesPorSemestrePorOpcaoCurso($semestre_inicio, $semestre_fim, $dados->disciplina, $dados->opcao_curso);

		$coluna['ano'] = "Ano";
		$coluna['semestre'] = "Semestre";
		$coluna['sr'] = "SR";
		$coluna['ii'] = "II";
		$coluna['mi'] = "MI";
		$coluna['mm'] = "MM";
		$coluna['ms'] = "MS";
		$coluna['ss'] = "SS";

		$obj = null;
		foreach($lista as $linha)
		{
			unset($obj);

			$total = $linha->sr + $linha->ii + $linha->mi + $linha->mm + $linha->ms + $linha->ss;
			$aprovados = $linha->mm + $linha->ms + $linha->ss;
			$reprovados = $linha->sr + $linha->ii + $linha->mi;

			$obj['Ano'] = $linha->ano;
			$obj['Semestre'] = $linha->semestre;
			$obj['Aprovados'] = round(($aprovados*100)/($total),2);
			$obj['Reprovados'] = round(($reprovados*100)/($total),2);

			$lista_retorno[] = $obj;
		}

		return $lista_retorno;
	}


	public function retornaArrayPorTurma($turma)
	{
		$lista_obj = & $this->retornaAlunosMatriculados($turma);

		if(count($lista_obj)) {
			foreach($lista_obj as $obj)
			{
				$lista_retorno[$obj->matricula] = $obj;
			}
		} else {
			$lista_retorno = null;
		}
		return $lista_retorno;
	}


	public function matricularAlunoTurma($aluno,$turma)
	{
		$aluno_codigo = $aluno;
		if (is_object($aluno)) {
			$aluno_codigo = $aluno->codigo;
		}

		$turma_codigo = $turma;
		if (is_object($turma)) {
			$turma_codigo = $turma->codigo;
		}

		$insert['aluno'] = $aluno_codigo;
		$insert['turma'] = $turma_codigo;
		$insert['status'] = "true";

		try {
			$this->DAO->inserir($insert);
		} catch (Exception $e) {
			$update['status'] = "true";
			unset($insert['status']);
			$this->DAO->updateCamposDeFiltro($update,$insert);
		}
	}


	public function desmatricularAlunoTurma($aluno,$turma)
	{
		$aluno_codigo = $aluno;
		if (is_object($aluno)) {
			$aluno_codigo = $aluno->codigo;
		}

		$turma_codigo = $turma;
		if (is_object($turma)) {
			$turma_codigo = $turma->codigo;
		}

		$filtro['aluno'] = $aluno_codigo;
		$filtro['turma'] = $turma_codigo;

		$update['status'] = "false";

		$this->DAO->updateCamposDeFiltro($update,$filtro);
	}


	public function zeraMediasMencoesFaltas($turma)
	{
		$filtro['turma'] = $turma->codigo;

		$update['mencao'] = null;
		$update['media'] = null;
		$update['faltas'] = null;
		$update['porcentagem_faltas'] = null;

		$this->DAO->updateCamposDeFiltro($update,$filtro);
	}

	public function estaMatriculado($aluno, $turma)
	{
		$aluno_codigo = $aluno;
		if (!is_numeric($aluno)) {
			$aluno_codigo = $aluno->codigo;
		}

		$turma_codigo = $turma;
		if (!is_numeric($turma)) {
			$turma_codigo = $turma->codigo;
		}

		$filtro['aluno'] = $aluno_codigo;
		$filtro['turma'] = $turma_codigo;

		$lista = $this->DAO->recuperaDeFiltro($filtro);

		if(count($lista)) {
			return true;
		} else {
			return false;
		}
	}
}
?>