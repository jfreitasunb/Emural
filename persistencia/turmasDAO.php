<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class TurmasDAO extends DAO
{
	private $mapaAtributosGeral;
	private $mapaAtributosGeralGrupo;

	function __construct()
	{
		$this->mapaAtributos["codigo"] = "tur_ctur";
		$this->mapaAtributos["professor"] = "tur_cpro";
		$this->mapaAtributos["disciplina"] = "tur_cdis";
		$this->mapaAtributos["periodo"] = "tur_peri";
		$this->mapaAtributos["descricao"] = "tur_desc";
		$this->mapaAtributos["ano"] = "tur_ano";
		$this->mapaAtributos["semestre"] = "tur_seme";
		$this->mapaAtributos["compisicao_nota"] = "tur_cnot";
		$this->mapaAtributos["sala"] = "tur_sala";
		$this->mapaAtributos["exibe_media"] = "tur_emed";
		$this->mapaAtributos["exibe_mencao"] = "tur_emen";
		$this->mapaAtributos["codigo_moodle"] = "tur_cmdl";

		$this->mapaAtributosGeral = $this->mapaAtributos;

		$this->mapaAtributosGeral["disciplina_descricao"] = "dis_desc";
		$this->mapaAtributosGeral["creditos"] = "dis_cred";
		$this->mapaAtributosGeral["codigo_cpd"] = "dis_ccpd";

		$this->mapaAtributosGeralGrupo = $this->mapaAtributosGeral;

		$this->mapaAtributosGeralGrupo["grupo_codigo"] = "gru_cgru";
		$this->mapaAtributosGeralGrupo["grupo_codigo_moodle"] = "gru_cmdl";

		$this->tabela = "turmas";
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

				FROM $this->tabela
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


	public function recuperaDeFiltroDeComposicaoTurma($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro, $this->mapaAtributosGeral);

		$ordem = $this->orderBy($ordemarray, $this->mapaAtributosGeral);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeral).",
						ctu_medi AS media,
						ctu_mens AS mencao

				FROM ($this->tabela
					 INNER JOIN composicao_turmas ON ctu_ctur = tur_ctur)
					 INNER JOIN disciplinas ON dis_cdis = tur_cdis

				$where
				$ordem";

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


	public function recuperaDeFiltroComGrupos($filtro, $ordemarray = null, $offset = null, $limit = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro, $this->mapaAtributosGeralGrupo);

		$ordem = $this->orderBy($ordemarray, $this->mapaAtributosGeralGrupo);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeralGrupo)."

				FROM ($this->tabela
					 INNER JOIN disciplinas ON dis_cdis = tur_cdis)
					 LEFT JOIN grupos ON tur_ctur = gru_ctur

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
}
?>