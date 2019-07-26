<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class PessoasDAO extends DAO
{
	function __construct()
	{
		$this->mapaAtributos["codigo"] = "pes_cpes";
		$this->mapaAtributos["usuario"] = "pes_usua";
		$this->mapaAtributos["senha"] = "pes_senh";
		$this->mapaAtributos["nome"] = "pes_nome";
		$this->mapaAtributos["tipo"] = "pes_tipo";
		$this->mapaAtributos["codigo_moodle"] = "pes_cmdl";
		$this->mapaAtributos["email"] = "pes_emai";
		$this->mapaAtributos["email_valido"] = "pes_eval";
		$this->mapaAtributos["email_confirmacao"] = "pes_econ";
		$this->mapaAtributos["senha_mudanca"] = "pes_smud";

		$this->tabela = "pessoas";
	}
}
?>