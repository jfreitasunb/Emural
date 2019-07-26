<?php

require_once $ROOT_PATH.'persistencia/daonn.php';

class ComposicaoTurmasDAO extends DAONxN
{
	private $mapaAtributosGeral;

	function __construct()
	{
		$this->mapaAtributos["aluno"] = "ctu_calu";
		$this->mapaAtributos["turma"] = "ctu_ctur";
		$this->mapaAtributos["mencao"] = "ctu_mens";
		$this->mapaAtributos["media"] = "ctu_medi";
		$this->mapaAtributos["faltas"] = "ctu_falt";
		$this->mapaAtributos["status"] = "ctu_stat";
		$this->mapaAtributos["porcentagem_faltas"] = "ctu_pfal";

		$this->mapaAtributosGeral = $this->mapaAtributos;

		$this->mapaAtributosGeral["codigo_aluno"] = "alu_calu";
		$this->mapaAtributosGeral["matricula"] = "alu_matr";
		$this->mapaAtributosGeral["recebimento_email"] = "alu_rema";
		$this->mapaAtributosGeral["opcao_curso"] = "alu_ocur";

		$this->mapaAtributosGeral["usuario"] = "pes_usua";
		$this->mapaAtributosGeral["senha"] = "pes_senh";
		$this->mapaAtributosGeral["nome"] = "pes_nome";
		$this->mapaAtributosGeral["tipo"] = "pes_tipo";
		$this->mapaAtributosGeral["codigo_moodle"] = "pes_cmdl";
		$this->mapaAtributosGeral["email"] = "pes_emai";
		$this->mapaAtributosGeral["email_valido"] = "pes_eval";
		$this->mapaAtributosGeral["email_confirmacao"] = "pes_econ";

		$this->tabela = "composicao_turmas";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeral)."
				FROM (($this->tabela
					 INNER JOIN alunos  ON alu_calu = ctu_calu)
					 INNER JOIN pessoas ON alu_calu = pes_cpes)

				$where
				$ordem";

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			print_r($res);
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		$lista = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $lista;
	}


	public function recuperaQuantidadeMencoesPorSemestrePorOpcaoCurso($semestre_inicio, $semestre_fim, $disciplina_codigo, $opcao_curso)
	{
		$this->conectar();

		$sql = "SELECT ano,
				       semestre,
				       CASE ct_sr WHEN ct_sr THEN ct_sr ELSE 0 END sr,
				       CASE ct_ii WHEN ct_ii THEN ct_ii ELSE 0 END ii,
				       CASE ct_mi WHEN ct_mi THEN ct_mi ELSE 0 END mi,
				       CASE ct_mm WHEN ct_mm THEN ct_mm ELSE 0 END mm,
				       CASE ct_ms WHEN ct_ms THEN ct_ms ELSE 0 END ms,
				       CASE ct_ss WHEN ct_ss THEN ct_ss ELSE 0 END ss

				FROM

				(((((((SELECT distinct tur_ano AS ano, tur_seme AS semestre FROM turmas WHERE tur_cdis = ".$disciplina_codigo." AND ((tur_ano = ".$semestre_inicio->ano." AND tur_seme >= ".$semestre_inicio->semestre.") OR tur_ano > ".$semestre_inicio->ano.") AND ((tur_ano = ".$semestre_fim->ano." AND ".$semestre_fim->semestre." <= 2) OR tur_ano < ".$semestre_fim->ano.") GROUP BY tur_ano, tur_seme) AS tb_semestres
				LEFT JOIN
				(SELECT tur_ano AS ano_sr, tur_seme AS semestre_sr, count(*) AS ct_sr FROM (composicao_turmas INNER JOIN turmas ON tur_ctur = ctu_ctur) INNER JOIN alunos ON alu_calu = ctu_calu WHERE alu_ocur = '".$opcao_curso."' AND ctu_mens = 'SR' AND tur_cdis = ".$disciplina_codigo." GROUP BY tur_ano,tur_seme) AS tb_sr
				ON ano_sr = ano AND semestre_sr = semestre)
				LEFT JOIN
				(SELECT tur_ano AS ano_ii, tur_seme AS semestre_ii, count(*) AS ct_ii FROM (composicao_turmas INNER JOIN turmas ON tur_ctur = ctu_ctur) INNER JOIN alunos ON alu_calu = ctu_calu WHERE alu_ocur = '".$opcao_curso."' AND ctu_mens = 'II' AND tur_cdis = ".$disciplina_codigo." GROUP BY tur_ano,tur_seme) AS tb_ii
				ON ano_ii = ano AND semestre_ii = semestre)
				LEFT JOIN
				(SELECT tur_ano AS ano_mi, tur_seme AS semestre_mi, count(*) AS ct_mi FROM (composicao_turmas INNER JOIN turmas ON tur_ctur = ctu_ctur) INNER JOIN alunos ON alu_calu = ctu_calu WHERE alu_ocur = '".$opcao_curso."' AND ctu_mens = 'MI' AND tur_cdis = ".$disciplina_codigo." GROUP BY tur_ano,tur_seme) AS tb_mi
				ON ano_mi = ano AND semestre_mi = semestre)
				LEFT JOIN
				(SELECT tur_ano AS ano_mm, tur_seme AS semestre_mm, count(*) AS ct_mm FROM (composicao_turmas INNER JOIN turmas ON tur_ctur = ctu_ctur) INNER JOIN alunos ON alu_calu = ctu_calu WHERE alu_ocur = '".$opcao_curso."' AND ctu_mens = 'MM' AND tur_cdis = ".$disciplina_codigo." GROUP BY tur_ano,tur_seme) AS tb_mm
				ON ano_mm = ano AND semestre_mm = semestre)
				LEFT JOIN
				(SELECT tur_ano AS ano_ms, tur_seme AS semestre_ms, count(*) AS ct_ms FROM (composicao_turmas INNER JOIN turmas ON tur_ctur = ctu_ctur) INNER JOIN alunos ON alu_calu = ctu_calu WHERE alu_ocur = '".$opcao_curso."' AND ctu_mens = 'MS' AND tur_cdis = ".$disciplina_codigo." GROUP BY tur_ano,tur_seme) AS tb_ms
				ON ano_ms = ano AND semestre_ms = semestre)
				LEFT JOIN
				(SELECT tur_ano AS ano_ss, tur_seme AS semestre_ss, count(*) AS ct_ss FROM (composicao_turmas INNER JOIN turmas ON tur_ctur = ctu_ctur) INNER JOIN alunos ON alu_calu = ctu_calu WHERE alu_ocur = '".$opcao_curso."' AND ctu_mens = 'SS' AND tur_cdis = ".$disciplina_codigo." GROUP BY tur_ano,tur_seme) AS tb_ss
				ON ano_ss = ano AND semestre_ss = semestre)";

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			print_r($res);
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		$lista = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $lista;
	}
}
?>
