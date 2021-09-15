<?php

require_once $ROOT_PATH.'persistencia/dao11.php';

class ProfessoresDAO extends DAO1x1
{
	private $mapaAtributosGeral;

	function __construct()
	{
		$this->mapaAtributos["codigo"] = "pro_cpro";
		$this->mapaAtributos["codigo_usuario_si"] = "pro_cuse";

		$this->mapaAtributosGeral = $this->mapaAtributos;

		$this->mapaAtributosGeral["usuario"] = "pes_usua";
		$this->mapaAtributosGeral["senha"] = "pes_senh";
		$this->mapaAtributosGeral["nome"] = "pes_nome";
		$this->mapaAtributosGeral["tipo"] = "pes_tipo";
		$this->mapaAtributosGeral["email"] = "pes_emai";
		$this->mapaAtributosGeral["codigo_moodle"] = "pes_cmdl";
		$this->mapaAtributosGeral["email_valido"] = "pes_eval";
		$this->mapaAtributosGeral["email_confirmacao"] = "pes_econ";

		$this->tabela = "professores";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null, $offset = null, $limit = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = $this->orderBy($ordemarray);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeral)."
				FROM ($this->tabela
					 INNER JOIN pessoas ON pro_cpro = pes_cpes)

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