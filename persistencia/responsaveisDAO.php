<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class ResponsaveisDAO extends DAO
{
	function __construct()
	{
		$this->mapaAtributos["codigo"] = "res_cres";
		$this->mapaAtributos["monitor"] = "res_cmon";
		$this->mapaAtributos["avaliacao"] = "res_cava";
		$this->mapaAtributos["lancar"] = "res_auto";
		$this->mapaAtributos["editar"] = "res_edit";
		$this->mapaAtributos["confiar"] = "res_conf";
		$this->mapaAtributos["valido"] = "res_vali";

		$this->tabela = "responsaveis";
	}


	public function recuperaDeAvaliacao($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SELECT ".$this->atributosSelect().",
					   ava_ctur AS turma

				FROM ($this->tabela
					 INNER JOIN avaliacoes ON res_cava = ava_cava AND ava_stat = 'true')
		
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


	public function recuperaDeAvaliacaoMonitor($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		$sql = "SELECT res_cres AS codigo,
					   ava_nome AS nome_avaliacao,
					   pes_nome AS nome_monitor

				FROM ((($this->tabela
					 INNER JOIN avaliacoes ON res_cava = ava_cava AND ava_stat = 'true')
					 INNER JOIN monitores ON res_cmon = mon_cmon)
					 INNER JOIN pessoas ON mon_cmon = pes_cpes)
		
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