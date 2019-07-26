<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class GruposDAO extends DAO
{
	function __construct()
	{
		$this->mapaAtributos["codigo"] = "gru_cgru";
		$this->mapaAtributos["turma"] = "gru_ctur";
		$this->mapaAtributos["codigo_moodle"] = "gru_cmdl";

		$this->mapaAtributosGeral = $this->mapaAtributos;

		$this->mapaAtributosGeral["ano"] = "tur_ano";
		$this->mapaAtributosGeral["semestre"] = "tur_seme";
		$this->mapaAtributosGeral["turma_professor"] = "tur_cpro";
		$this->mapaAtributosGeral["turma_disciplina"] = "tur_cdis";
		$this->mapaAtributosGeral["turma_periodo"] = "tur_peri";
		$this->mapaAtributosGeral["turma_descricao"] = "tur_desc";
		$this->mapaAtributosGeral["turma_codigo_moodle"] = "tur_cmdl";

		$this->mapaAtributosGeral["disciplina_descricao"] = "dis_desc";
		$this->mapaAtributosGeral["disciplina_creditos"] = "dis_cred";
		$this->mapaAtributosGeral["disciplina_codigo_cpd"] = "dis_ccpd";

		$this->tabela = "grupos";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null, $offset = null, $limit = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro, $this->mapaAtributosGeral);

		$ordem = $this->orderBy($ordemarray, $this->mapaAtributosGeral);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeral)."

				FROM ($this->tabela
					  INNER JOIN turmas ON tur_ctur = gru_ctur)
					  INNER JOIN disciplinas ON dis_cdis = tur_cdis

				$where
				$ordem
				$limit
				$offset";

		$res = $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			print_r($res);
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		$lista = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $lista;
	}


	public function recuperaDisciplinasQuePossuemGrupoNoSemestre($semestre)
	{
		$this->conectar();

		$mapaAtributos = Array();
		$mapaAtributos["codigo"] = "dis_cdis";
		$mapaAtributos["descricao"] = "dis_desc";
		$mapaAtributos["creditos"] = "dis_cred";
		$mapaAtributos["codigo_cpd"] = "dis_ccpd";
		$mapaAtributos["codigo_moodle"] = "tur_cmdl";

		$sql = "SELECT DISTINCT ".$this->atributosSelect($mapaAtributos)."

				FROM ($this->tabela
					  INNER JOIN turmas ON tur_ctur = gru_ctur)
					  INNER JOIN disciplinas ON dis_cdis = tur_cdis

				WHERE tur_ano = $semestre->ano AND tur_seme = $semestre->semestre";

		$res = $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			print_r($res);
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		$lista = $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $lista;
	}
}
?>