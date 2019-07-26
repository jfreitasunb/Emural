<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class AvaliacoesDAO extends DAO
{
	function __construct()
	{
		$this->mapaAtributos["codigo"] = "ava_cava";
		$this->mapaAtributos["turma"] = "ava_ctur";
		$this->mapaAtributos["ordem"] = "ava_orde";
		$this->mapaAtributos["tipo"] = "ava_tipo";
		$this->mapaAtributos["data_realizacao"] = "ava_drea";
		$this->mapaAtributos["divulgacao"] = "ava_divu";
		$this->mapaAtributos["data_divulgacao"] = "ava_ddiv";
		$this->mapaAtributos["nome"] = "ava_nome";
		$this->mapaAtributos["nome_resumido"] = "ava_nres";
		$this->mapaAtributos["status"] = "ava_stat";

		$this->tabela = "avaliacoes";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = $this->orderBy($ordemarray);

		$sql = "SET DATESTYLE = SQL, DMY;
				SELECT ".$this->atributosSelect()." FROM $this->tabela $where $ordem";

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


	public function recuperaAvaliacoesAplicadas($turma,$ordemarray = null)
	{
		$this->conectar();

		$ordem = $this->orderBy($ordemarray);

		$sql = "SET DATESTYLE = SQL, DMY;
				SELECT DISTINCT ".$this->atributosSelect()."
				FROM $this->tabela
					 INNER JOIN notas ON not_cava = ava_cava
				WHERE ava_ctur = $turma->codigo AND
					  ava_stat = 'true'
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
}
?>