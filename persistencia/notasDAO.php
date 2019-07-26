<?php

require_once $ROOT_PATH.'persistencia/daonn.php';

class NotasDAO extends DAONxN
{
	private $mapaAtributosGeral;

	function __construct()
	{
		$this->mapaAtributos["aluno"] = "not_calu";
		$this->mapaAtributos["avaliacao"] = "not_cava";
		$this->mapaAtributos["valor"] = "not_valo";
		$this->mapaAtributos["observacao"] = "not_obs";

		$this->mapaAtributosGeral = $this->mapaAtributos;

		$this->mapaAtributosGeral["codigo_aluno"] = "alu_calu";
		$this->mapaAtributosGeral["matricula"] = "alu_matr";
		$this->mapaAtributosGeral["recebimento_email"] = "alu_rema";

		$this->mapaAtributosGeral["aluno_composicao_turmas"] = "ctu_calu";
		$this->mapaAtributosGeral["turma"] = "ctu_ctur";
		$this->mapaAtributosGeral["mensao"] = "ctu_mens";
		$this->mapaAtributosGeral["media"] = "ctu_medi";
		$this->mapaAtributosGeral["faltas"] = "ctu_falt";
		$this->mapaAtributosGeral["status_matricula"] = "ctu_stat";

		$this->tabela = "notas";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro,$this->mapaAtributosGeral);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeral)."
				FROM (($this->tabela
					 INNER JOIN alunos ON ".$this->mapaAtributosGeral["codigo_aluno"]." =  ".$this->mapaAtributosGeral["aluno"].")
					 INNER JOIN composicao_turmas ON ".$this->mapaAtributosGeral["codigo_aluno"]." =  ".$this->mapaAtributosGeral["aluno_composicao_turmas"].")

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


	public function recuperaDeFiltroDeAvaliacoes($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SELECT ava_cava AS avaliacao,
					   not_calu AS aluno,
					   ava_nres AS descricao_resumida,
					   ava_nome AS descricao,
					   not_valo AS valor
				FROM ($this->tabela
					 INNER JOIN avaliacoes ON not_cava = ava_cava AND ava_stat = 'true')

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


	public function recuperaQuantidadeMencoesDeTurma($turma)
	{
		$this->conectar();

		$sql = "SELECT id_nome AS codigo,
       desc_nome AS nome,
       CASE ct_sr WHEN ct_sr THEN ct_sr ELSE 0 END sr,
       CASE ct_ii WHEN ct_ii THEN ct_ii ELSE 0 END ii,
       CASE ct_mi WHEN ct_mi THEN ct_mi ELSE 0 END mi,
       CASE ct_mm WHEN ct_mm THEN ct_mm ELSE 0 END mm,
       CASE ct_ms WHEN ct_ms THEN ct_ms ELSE 0 END ms,
       CASE ct_ss WHEN ct_ss THEN ct_ss ELSE 0 END ss

FROM

((((((SELECT DISTINCT ava_cava AS id_nome, ava_nome AS desc_nome, ava_drea AS data_nome FROM notas n_nome Inner JOIN avaliacoes ON ava_cava = not_cava AND ava_stat = 'true' WHERE ava_ctur = $turma->codigo GROUP BY ava_cava, ava_nome, ava_drea ) AS tb_nome
LEFT JOIN
(SELECT DISTINCT ava_cava AS id_sr, COUNT(*) ct_sr FROM notas Inner JOIN avaliacoes ON ava_cava = not_cava WHERE ava_ctur = $turma->codigo AND not_valo = 0 GROUP BY ava_cava) AS tb_sr
ON id_nome = id_sr)
LEFT JOIN
(SELECT DISTINCT ava_cava AS id_ii, COUNT(*) ct_ii FROM notas Inner JOIN avaliacoes ON ava_cava = not_cava WHERE ava_ctur = $turma->codigo AND not_valo > 0 AND not_valo < 3 GROUP BY ava_cava) AS tb_ii
ON id_nome = id_ii)
LEFT JOIN
(SELECT DISTINCT ava_cava AS id_mi, COUNT(*) ct_mi FROM notas Inner JOIN avaliacoes ON ava_cava = not_cava WHERE ava_ctur = $turma->codigo AND not_valo >= 3 AND not_valo < 5 GROUP BY ava_cava) AS tb_mi
ON id_nome = id_mi)
LEFT JOIN
(SELECT DISTINCT ava_cava AS id_mm, COUNT(*) ct_mm FROM notas Inner JOIN avaliacoes ON ava_cava = not_cava WHERE ava_ctur = $turma->codigo AND not_valo >= 5 AND not_valo < 7 GROUP BY ava_cava) AS tb_mm
ON id_nome = id_mm)
LEFT JOIN
(SELECT DISTINCT ava_cava AS id_ms, COUNT(*) ct_ms FROM notas Inner JOIN avaliacoes ON ava_cava = not_cava WHERE ava_ctur = $turma->codigo AND not_valo >= 7 AND not_valo < 9 GROUP BY ava_cava) AS tb_ms
ON id_nome = id_ms)
LEFT JOIN
(SELECT DISTINCT ava_cava AS id_ss, COUNT(*) ct_ss FROM notas Inner JOIN avaliacoes ON ava_cava = not_cava WHERE ava_ctur = $turma->codigo AND not_valo >= 9 AND not_valo <= 10 GROUP BY ava_cava) AS tb_ss
ON id_nome = id_ss

ORDER BY data_nome";
//print_r($sql);
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


	public function recuperaDeFiltroDeAvaliacoesCompleto($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SET DATESTYLE = SQL, DMY;
				SELECT ava_cava AS avaliacao,
					   not_calu AS aluno,
					   ava_nres AS descricao_resumida,
					   ava_nome AS descricao,
					   not_valo AS valor,
					   not_obs  AS observacao,
					   ava_drea AS data
				FROM ($this->tabela
					 INNER JOIN avaliacoes ON not_cava = ava_cava AND ava_stat = 'true')

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
}
?>