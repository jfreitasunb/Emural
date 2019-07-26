<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class ObservacoesDAO extends DAO
{
	private $mapaAtributosGeral;

	function __construct()
	{
		$this->mapaAtributos["codigo"] = "obs_cobs";
		$this->mapaAtributos["turma"] = "obs_ctur";
		$this->mapaAtributos["titulo"] = "obs_titu";
		$this->mapaAtributos["descricao"] = "obs_desc";
		$this->mapaAtributos["data_divulgacao"] = "obs_data";
		$this->mapaAtributos["valido"] = "obs_vali";

		$this->tabela = "observacoes";
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
}
?>