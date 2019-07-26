<?php

require_once $ROOT_PATH.'persistencia/dao.php';

define('AVALIACAO_TIPO', 1);

define('LIMIT_AUTO_SUGGEST',5);

class Codigo_ItemDAO extends DAO
{
	function __construct()
	{
		$this->mapaAtributos["codigo"] = "cit_ccit";
		$this->mapaAtributos["tipo"] = "cit_ccod";
		$this->mapaAtributos["descricao"] = "cit_desc";
		$this->mapaAtributos["descricao_resumida"] = "cit_dres";
		$this->mapaAtributos["descricao_resumida_2"] = "cit_dre2";

		$this->tabela = "codigo_item";
	}


	function recuperaAutoSuggestTipoAvaliacao($busca)
	{
		$this->conectar();

		$sql = "SELECT ".$this->atributosSelect()."
				FROM $this->tabela
				WHERE ".$this->mapaAtributos["tipo"]." = ".AVALIACAO_TIPO." AND UPPER( TO_ASCII(convert_to(cit_desc, 'LATIN1'),'LATIN1')) LIKE UPPER( TO_ASCII(convert_to('".addslashes($busca)."%','LATIN1'),'LATIN1'))
				ORDER BY cit_desc DESC
				LIMIT ".LIMIT_AUTO_SUGGEST;

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		$lista = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $lista;
	}


	function recuperaPorTipoDescricaoResumida2($tipo,$busca)
	{
		$this->conectar();

		$sql = "SELECT ".$this->atributosSelect()."
				FROM $this->tabela
				WHERE ".$this->mapaAtributos["tipo"]." = ".$tipo." AND UPPER( TO_ASCII(convert_to(cit_dre2, 'LATIN1'),'LATIN1')) LIKE UPPER( TO_ASCII(convert_to('".addslashes($busca)."','LATIN1'),'LATIN1'))
				ORDER BY cit_desc DESC
				LIMIT ".LIMIT_AUTO_SUGGEST;

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		$lista = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		return $lista;
	}
}
?>