<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class MonitoresDAO extends DAO
{
	private $mapaAtributosGeral;

	function __construct()
	{
		$this->mapaAtributos["codigo"] = "mon_cmon";
		$this->mapaAtributos["codigo_usuario_si"] = "mon_cuse";
		$this->mapaAtributos["status"] = "mon_stat";

		$this->mapaAtributosGeral = $this->mapaAtributos;

		$this->mapaAtributosGeral["usuario"] = "pes_usua";
		$this->mapaAtributosGeral["senha"] = "pes_senh";
		$this->mapaAtributosGeral["nome"] = "pes_nome";
		$this->mapaAtributosGeral["tipo"] = "pes_tipo";

		$this->tabela = "monitores";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = $this->orderBy($ordemarray);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeral)."
				FROM ($this->tabela
					 INNER JOIN pessoas ON mon_cmon = pes_cpes)

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
}
?>