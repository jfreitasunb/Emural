<?php

require_once $ROOT_PATH.'persistencia/dao11.php';

class AlunosDAO extends DAO1x1
{
	private $mapaAtributosGeral;

	function __construct()
	{
		$this->mapaAtributos["codigo"] = "alu_calu";
		$this->mapaAtributos["matricula"] = "alu_matr";
		$this->mapaAtributos["recebimento_email"] = "alu_rema";
		$this->mapaAtributos["opcao_curso"] = "alu_ocur";

		$this->mapaAtributosGeral = $this->mapaAtributos;

		$this->mapaAtributosGeral["usuario"] = "pes_usua";
		$this->mapaAtributosGeral["senha"] = "pes_senh";
		$this->mapaAtributosGeral["nome"] = "pes_nome";
		$this->mapaAtributosGeral["tipo"] = "pes_tipo";
		$this->mapaAtributosGeral["email"] = "pes_emai";
		$this->mapaAtributosGeral["codigo_moodle"] = "pes_cmdl";
		$this->mapaAtributosGeral["email_valido"] = "pes_eval";
		$this->mapaAtributosGeral["email_confirmacao"] = "pes_econ";

		$this->tabela = "alunos";
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro,$this->mapaAtributosGeral);

		$ordem = $this->orderBy($ordemarray);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosGeral)."
				FROM ($this->tabela
					 INNER JOIN pessoas ON alu_calu = pes_cpes)

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


	public function recuperaDistinctOpcaoCursoDeFiltro($filtro, $ordemarray = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = $this->orderBy($ordemarray);

		$sql = "SELECT distinct alu_ocur as opcao_curso
				FROM $this->tabela

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