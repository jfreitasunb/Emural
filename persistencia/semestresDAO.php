<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class SemestresDAO extends DAO
{
	function __construct()
	{
		$this->mapaAtributos["codigo"] = "sem_csem";
		$this->mapaAtributos["ano"] = "sem_ano";
		$this->mapaAtributos["semestre"] = "sem_seme";
		$this->mapaAtributos["inicio"] = "sem_inic";
		$this->mapaAtributos["fim"] = "sem_fim";

		$this->tabela = "semestres";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null, $offset = null, $limit = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SET DATESTYLE = SQL, DMY;
				SELECT ".$this->atributosSelect()." FROM $this->tabela $where $ordem $limit $offset";


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
