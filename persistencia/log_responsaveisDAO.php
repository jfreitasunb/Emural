<?php

require_once $ROOT_PATH.'persistencia/daonn.php';

class LogResponsaveisDAO extends DAO
{
	private $mapaAtributosGeral;

	function __construct()
	{
		$this->mapaAtributos["codigo"] = "lre_clre";
		$this->mapaAtributos["responsavel"] = "lre_cres";
		$this->mapaAtributos["descricao"] = "lre_desc";
		$this->mapaAtributos["data_hora"] = "lre_dhor";

		$this->tabela = "log_responsaveis";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SET DATESTYLE = SQL, DMY;
				SELECT ".$this->atributosSelect()." FROM $this->tabela $where $ordem";

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


	public function recuperaDeFiltroComResponsaveisAvaliacoesMonitor($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SET DATESTYLE = SQL, DMY;
				SELECT ".$this->atributosSelect().",
						pes_nome AS nome
						
				FROM (($this->tabela INNER JOIN responsaveis ON res_cres = lre_cres)
									 INNER JOIN avaliacoes ON ava_cava = res_cava AND ava_stat = 'true')
									 INNER JOIN pessoas ON res_cmon = pes_cpes
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