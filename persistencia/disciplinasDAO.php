<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class DisciplinasDAO extends DAO
{
	function __construct()
	{
		$this->mapaAtributos["codigo"] = "dis_cdis";
		$this->mapaAtributos["descricao"] = "dis_desc";
		$this->mapaAtributos["departamento"] = "dis_dep";
		$this->mapaAtributos["numero_aulas"] = "dis_naul";
		$this->mapaAtributos["codigo_cpd"] = "dis_ccpd";
		$this->mapaAtributos["creditos"] = "dis_cred";

		$this->tabela = "disciplinas";
	}
}
?>