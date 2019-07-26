<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class DAONxN extends DAO
{
	public function inserir($insert)
	{
		$this->conectar();

		$this->_db->beginTransaction();

		$sql = "INSERT INTO $this->tabela ".$this->insertCampos($insert)." VALUES ".$this->insertValores($insert) ;

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			//print_r($res);
			$this->_db->rollback();
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		if ($this->_db->inTransaction())
		{
			$this->_db->commit();
		}

		$retorno = new stdClass();
		foreach($insert as $key => $value)
		{
			$retorno->$key .= $value;
		}

		return $retorno;
	}
}
?>