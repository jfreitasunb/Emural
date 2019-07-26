<?php

require_once $ROOT_PATH."persistencia/semestresDAO.php";
require_once $ROOT_PATH.'lib/bo.php';
require_once $ROOT_PATH.'lib/utilBO.php';

class SemestresBO extends BO
{
	function __construct()
	{
		$this->DAO = new SemestresDAO();
	}


	public function retornaUltimoSemestre()
	{
		$ordem["ano"] = "DESC";
		$ordem["semestre"] = "DESC";

		$lista = & $this->DAO->recuperaDeFiltro(null,$ordem,0,1);

		if(count($lista)) {
			return $lista[0];
		} else {
			return null;
		}
	}


	public function preencheFormularioCoordenadorSemestres($tpl, $semestre)
	{
		$this->preencherObjeto($tpl,$semestre,"semestre_");
	}


	public function inserirAtualizar($semestre, $semestre_atualizar)
	{
		GLOBAL $ALERTAS;

		$return = false;
		if ($semestre && $semestre_atualizar->ano == $semestre->ano && $semestre_atualizar->semestre == $semestre->semestre) {
			$filtro['codigo'] = $semestre->codigo;
			$this->DAO->updateCamposDeFiltro($semestre_atualizar,$filtro);
			$ALERTAS["SEMAS"] = "";
		} elseif (!$semestre || $semestre_atualizar->ano > $semestre->ano || ($semestre_atualizar->ano == $semestre->ano && $semestre_atualizar->semestre > $semestre->semestre)) {
			$this->DAO->inserir($semestre_atualizar);
			$ALERTAS['SEMIS'] = "";
			$return = true;
		} else {
			$ALERTAS["SEMMAA"] = "";
		}

		return $return;
	}


	public function preencheComboAnoSemestreExcetoAtual($tpl,$turma)
	{
		$ordem["ano"] = "DESC";
		$ordem["semestre"] = "DESC";

		$lista = & $this->DAO->recuperaDeFiltro(null,$ordem,1);

		if(count($lista)) {
			foreach($lista as $semestre)
			{
				$preencher->codigo = $semestre->codigo;
				$preencher->descricao = $semestre->ano."/".$semestre->semestre;

				if($turma !== null) {
					if($turma->ano == $semestre->ano && $turma->semestre == $semestre->semestre) {
						$preencher->selected = 'selected="selected"';
					} else {
						$preencher->selected = "";
					}
				}

				$this->preencherObjeto($tpl,$preencher,"ano_semestre_","adicionar_ano_semestre");
			}
		}
	}


	public function preencheComboAnoSemestreExcetoAtualRelatorioPorcentagemMencoes($tpl,$dados)
	{
		$ordem["ano"] = "DESC";
		$ordem["semestre"] = "DESC";

		$lista = & $this->DAO->recuperaDeFiltro(null,$ordem,1);

		if(count($lista)) {
			foreach($lista as $semestre)
			{
				$preencher->codigo = $semestre->codigo;
				$preencher->descricao = $semestre->ano."/".$semestre->semestre;

				if($dados !== null) {
					if($dados->inicio == $semestre->codigo) {
						$preencher->selected = 'selected="selected"';
					} else {
						$preencher->selected = "";
					}
				}

				$this->preencherObjeto($tpl,$preencher,"ano_semestre_inicio_","adicionar_ano_semestre_inicio");


				if($dados !== null) {
					if($dados->fim == $semestre->codigo) {
						$preencher->selected = 'selected="selected"';
					} else {
						$preencher->selected = "";
					}
				}

				$this->preencherObjeto($tpl,$preencher,"ano_semestre_fim_","adicionar_ano_semestre_fim");
			}
		}
	}


	public function preencheComboAnoSemestreExcetoAtualRelatorioListaAlunos($tpl,$dados)
	{
		$ordem["ano"] = "DESC";
		$ordem["semestre"] = "DESC";

		$lista = & $this->DAO->recuperaDeFiltro(null,$ordem,1);

		if(count($lista)) {
			foreach($lista as $semestre)
			{
				$preencher->codigo = $semestre->codigo;
				$preencher->descricao = $semestre->ano."/".$semestre->semestre;

				if($dados !== null) {
					if($dados->semestre == $semestre->codigo) {
						$preencher->selected = 'selected="selected"';
					} else {
						$preencher->selected = "";
					}
				}

				$this->preencherObjeto($tpl,$preencher,"ano_semestre_","adicionar_ano_semestre");
			}
		}
	}


	public function preencheDatasConfiguracaoRapida($tpl,$semestre)
	{
		$data_inicio = new DateTime(UtilBO::getDataPadraoISO($semestre->inicio));
		$data_fim = new DateTime(UtilBO::getDataPadraoISO($semestre->fim));
		$intervalo = $data_fim->diff($data_inicio);
		$quantidade_dias = $intervalo->format('%a');

		$espaco = round($quantidade_dias/3);

		$data_inicio->add(new DateInterval('P'.$espaco.'D'));

		$data1 = date_format($data_inicio,'d/m/Y');

		$data_inicio->add(new DateInterval('P'.$espaco.'D'));

		$data2 = date_format($data_inicio,'d/m/Y');

		$data3 = date_format($data_fim,'d/m/Y');

		$tpl->setVariable(array(
			"data_prova_1"  => $data1,
			"data_prova_2"  => $data2,
			"data_prova_3"  => $data3
		));
	}
}
?>