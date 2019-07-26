<?php

require_once $ROOT_PATH."persistencia/notasDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/calcular_mediaBO.php';

class NotasBO extends BO
{
	function __construct()
	{
		$this->DAO = & new NotasDAO();
	}


	public function retornaNotasDeAvaliacao($avaliacao)
	{
		$filtro["avaliacao"] = $avaliacao->codigo;
		$filtro["status_matricula"] = "true";
		$filtro["turma"] = $avaliacao->turma;

		$ordem["matricula"] = "ASC";

		$lista = & $this->DAO->recuperaDeFiltro($filtro,$ordem);

		if(count($lista)) {
			return $lista;
		} else {
			return null;
		}
	}


	public function inserir($avaliacao,$notas)
	{
		$filtro["avaliacao"] = $inserir["avaliacao"] = $avaliacao->codigo;
		foreach($notas as $valor)
		{
			$nota = $valor->nota;
			if(strlen($nota) == 0) {
				$nota = null;
			} else {
				$nota = str_replace(',','.',$nota);
			}

			$filtro["aluno"] = $inserir["aluno"] = $valor->aluno_codigo;
			$campos["valor"] = $inserir["valor"] = $nota;
			$campos["observacao"] = $inserir["observacao"] = $valor->observacao;

			try {
				$this->DAO->inserir($inserir);
			} catch (Exception $e) {
				$this->DAO->updateCamposDeFiltro($campos,$filtro);
			}
		}
	}


	public function retornaMediaMencao($turma, $aluno)
	{
		$notas = $this->retornaNotasParaCalculoMedia($turma->codigo,$aluno->codigo);

		$calcular = & new calcularMediaBO();

		$return["media"] = $calcular->executar($turma->compisicao_nota,$notas);
		$return["mencao"] = $this->mencaoDaMedia($return["media"]);

		return $return;
	}


	public function retornaNotasParaCalculoMedia($turma_codigo,$aluno_codigo)
	{
		$filtro["aluno"] = $aluno_codigo;
		$filtro["ava_ctur"] = $turma_codigo;

		$lista = & $this->DAO->recuperaDeFiltroDeAvaliacoes($filtro);

		$notas = null;

		if(count($lista)) {
			foreach($lista as $nota)
			{
				$notas[$nota->descricao_resumida] = $nota->valor;
			}
		}
		return $notas;
	}


	private function mencaoDaMedia($media)
	{
		if($media == 0)
			return "SR";
		if($media < 3)
			return "II";
		if($media < 5)
			return "MI";
		if($media < 7)
			return "MM";
		if($media < 9)
			return "MS";
		return "SS";
	}


	public function preencheGraficoNotasTurma($tpl, $turma)
	{
		$lista = & $this->DAO->recuperaQuantidadeMencoesDeTurma($turma);

		if(count($lista)) {
			$preenche->quantidade_sr = "";
			$preenche->quantidade_ii = "";
			$preenche->quantidade_mi = "";
			$preenche->quantidade_mm = "";
			$preenche->quantidade_ms = "";
			$preenche->quantidade_ss = "";
			$preenche->nome_avaliacao = "";
			foreach($lista as $provas)
			{
				$preenche->quantidade_sr .= $provas->sr.", ";
				$preenche->quantidade_ii .= $provas->ii.", ";
				$preenche->quantidade_mi .= $provas->mi.", ";
				$preenche->quantidade_mm .= $provas->mm.", ";
				$preenche->quantidade_ms .= $provas->ms.", ";
				$preenche->quantidade_ss .= $provas->ss.", ";
				$preenche->nome_avaliacao .= "'$provas->nome', ";
			}
			$preenche->quantidade_sr = substr($preenche->quantidade_sr, 0, strlen($preenche->quantidade_sr) - 2);
			$preenche->quantidade_ii = substr($preenche->quantidade_ii, 0, strlen($preenche->quantidade_ii) - 2);
			$preenche->quantidade_mi = substr($preenche->quantidade_mi, 0, strlen($preenche->quantidade_mi) - 2);
			$preenche->quantidade_mm = substr($preenche->quantidade_mm, 0, strlen($preenche->quantidade_mm) - 2);
			$preenche->quantidade_ms = substr($preenche->quantidade_ms, 0, strlen($preenche->quantidade_ms) - 2);
			$preenche->quantidade_ss = substr($preenche->quantidade_ss, 0, strlen($preenche->quantidade_ss) - 2);
			$preenche->nome_avaliacao = substr($preenche->nome_avaliacao, 0, strlen($preenche->nome_avaliacao) - 2);

			$this->preencherObjeto($tpl,$preenche);
		}
	}


	public function retornaNotasTurmaAluno($turma, $aluno)
	{
		$filtro["aluno"] = $aluno->codigo;
		$filtro["ava_ctur"] = $turma->codigo;
		$filtro["ava_divu"] = "true";

		$ordem['ava_drea'] = "ASC";

		$lista = & $this->DAO->recuperaDeFiltroDeAvaliacoesCompleto($filtro,$ordem);

		if(count($lista))
			return $lista;
		else
			return null;
	}
}
?>