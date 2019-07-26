<?php
/**
 * AQUI DEVE ENTRAR UM CABECALHO PADRAO DO SISTEMA *
 */
require_once 'MDB2.php';

/**
 * Essa classe deve ser extendida por outras classes de Acesso a Recursos.
 * (ie. DAO: Data Access Object).
 *
 * Recursos nesse contexto entede-se por Acesso ao Banco de Dados.
 *
 * Aqui tem os m�todos principais que todas as DAOs que extenderem
 * devem ter.
 *
 * @author Paulo Angelo <pa@mat.unb.br>
 */
define('DB_PORTABILITY_ALL', 0);

class DAO
{
	/**
	 * Essa � o ponteiro para a conex�o no BD
	 * Como estamos usando MDB2, � um objeto desse pacote
	 */
	protected $_db;

	protected $mapaAtributos;

	function __construct()
	{
		$this->tabela = "";
	}

	/**
	 * Pega as informa��es no arquivo config.inc.php
	 * e cria uma conex�o ao banco de dados do SIEX
	 * usando o pacote MDB2 do Pear
	 *
	 * @return 1 se houver erro e 0 se ocorrer tudo bem
	 *
	 */
    protected function conectar($db = null)
    {
    	if($db === null) {
        	GLOBAL $BANCO;
        	$db = $BANCO;
    	}

        $dsn = array(
             'phptype'  => 'pgsql'            ,
             'username' => $db["user"]    ,
             'password' => $db["password"],
             'hostspec' => $db["host"]    ,
             'database' => $db["dbname"],
             'port'		=> $db["dbport"],
            );

		$options = array(
            'debug'       => 2,
            'portability' => DB_PORTABILITY_ALL,
			//'disable_smart_seqname' => false
		);

		$mdb2 = new MDB2();

		$this->_db = $mdb2->connect($dsn, $options);

		if (PEAR::isError($this->_db)) {
			print_r($this->_db);
			$this->log("Erro acesso banco",$this->_db->getMessage());
			//die($this->_db->getMessage());
			throw new Exception("Erro de acesso ao banco");
		}

		if(isset($CHARSET))
			$this->_db->setCharset($CHARSET);

		$this->_db->loadModule('Extended', null, false);
		$this->_db->setFetchMode(MDB2_FETCHMODE_ASSOC);

		//$this->_db->query("SET search_path = ".$BANCO ["schema"].", pg_catalog");
        //$this->_db->query("update anuncio set anu_emai = 'teste' where anu_canu = 498522");

		return 0;
	}


	protected function whereDeFiltro($filtro, $atributos = null)
	{
		if($atributos === null) {
			$atributos = $this->mapaAtributos;
		}
		$where="";

		if(count($filtro)) {
			foreach($filtro as $key => $value)
			{
				if (array_key_exists($key, $atributos)) {
					$campo = $atributos[$key];
				} else {
					$campo = $key;
				}
				$where .= " ".pg_escape_string($campo)." = '".pg_escape_string($value)."' AND";
			}
		}

		if(strlen($where)>0)
		{
			$where = " WHERE ".substr($where,0,strlen($where)-3);
		}

		return $where;
	}


	protected function where($filtro)
	{
		$where = "";

		foreach($filtro as $key => $value)
		{
			$where .= " ".pg_escape_string($key)." = ";

			if(is_int($value))
				$where .= pg_escape_string($value)." AND";
			else
				$where .= "'".pg_escape_string($value)."' AND";
		}

		if(strlen($where)>0)
		{
			$where = " WHERE ".substr($where,0,strlen($where)-3);
		}

		return $where;
	}


	protected function orderBy($ordem, $atributos = NULL)
	{
		if ($atributos === NULL) {
			$atributos = $this->mapaAtributos;
		}

		$orderby = "";
		if($ordem != null) {
			foreach($ordem as $key => $value)
			{
				if (array_key_exists($key, $atributos)) {
					$campo = $atributos[$key];
				} else {
					$campo = $key;
				}
				$orderby .= " ".pg_escape_string($campo)." ".pg_escape_string($value).",";
			}
		}

		if(strlen($orderby) > 0)
		{
			$orderby = " ORDER BY ".substr($orderby,0,strlen($orderby)-1);
		}

		return $orderby;
	}


	protected function updateSet($campos)
	{
		$retorno = "";

		foreach($campos as $key => $value)
		{
			if($value === null) {
				$retorno .= " ".$this->mapaAtributos[$key]." = null,";
			} else {
				$retorno .= " ".$this->mapaAtributos[$key]." = '".pg_escape_string($value)."',";
			}
		}

		$retorno = substr($retorno,0,strlen($retorno)-1);

		return $retorno;
	}


	protected function atributosSelect($atributos = null)
	{
		if($atributos === null) {
			$atributos = $this->mapaAtributos;
		}
		$select = "";

		foreach($atributos as $key => $value)
		{
			$select .= " ".$value." as ".pg_escape_string($key).",";
		}

		return substr($select,0,strlen($select)-1);
	}


	protected function insertCampos($campos)
	{
		$retorno="(";

		foreach($campos as $key => $value)
		{
			$retorno .= $this->mapaAtributos[$key].", ";
			$campos2[$this->mapaAtributos[$key]] = $value;
		}
		$campos = $campos2;

		$retorno = substr($retorno,0,strlen($retorno)-2).")";

		return $retorno;
	}


	protected function insertValores($campos)
	{
		$retorno="(";

		foreach($campos as $key => $value)
		{
			if(strlen($value) != 0)
				$retorno .= "'".pg_escape_string($value)."',";
			else
				$retorno .= "null,";
		}

		$retorno = substr($retorno,0,strlen($retorno)-1).")";
		return $retorno;
	}


	protected function log($titulo,$descricao)
	{
		GLOBAL $ROOT_PATH;
		if(strlen($titulo) < 20)
			$titulo = str_pad($titulo,20," ",STR_PAD_RIGHT);
		else
			$titulo = substr($titulo,0,20);
		$log = fopen( $ROOT_PATH."log/log.txt", "a" );
		$texto = date('d/m/Y H:i:s')." - ".$titulo." - ".$descricao."\n";
		fwrite($log, $texto);
		fclose($log);
	}

	protected function desconectar()
	{
		$this->_db->disconnect();
	}


	public function recuperaDeFiltro($filtro, $ordemarray = null, $offset = null, $limit = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$ordem = & $this->orderBy($ordemarray);

		if(strlen($limit) > 0)
			$limit = "LIMIT $limit";

		if(strlen($offset) > 0)
			$offset = "OFFSET $offset";

		$sql = "SELECT ".$this->atributosSelect()." FROM $this->tabela $where $ordem $limit $offset";

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


	public function inserir($insert)
	{
		$this->conectar();

		$this->_db->beginTransaction();

		$res = & $this->_db->query("SELECT NEXTVAL('".$this->tabela."_".$this->mapaAtributos["codigo"]."_seq"."')");

		if(PEAR::isError($res)) {
			print_r($res);
			$this->_db->rollback();
			throw new Exception("Erro de insersao no banco!");
		}
		$lista = & $res->fetchAll(MDB2_FETCHMODE_OBJECT);

		$codigo = $lista[0]->nextval;

		/*$codigo = $this->_db->nextID($this->tabela);
		if(PEAR::isError($codigo)) {
			print_r($codigo);
			throw new Exception("Erro de insersao no banco!");
		}*/

		if(is_array($insert)) {
			$insert['codigo'] = $codigo;
		} else {
			$insert->codigo = $codigo;
		}

		$sql = "INSERT INTO $this->tabela ".$this->insertCampos($insert)." VALUES ".$this->insertValores($insert) ;

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res)) {
			print_r($res);
			$this->_db->rollback();
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro de insersao no banco!");
		}

		if ($this->_db->inTransaction()) {
			$this->_db->commit();
		}

		$retorno = new stdClass();
		foreach($insert as $key => $value) {
			$retorno->$key .= $value;
		}

		return $retorno;
	}


	public function updateCamposDeFiltro($campos,$filtro = null)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$set = $this->updateSet($campos);

		$sql = "UPDATE $this->tabela SET $set $where";
		//echo $sql."<br>"; return;

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			echo $sql;
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}
	}


	public function deletaDeFiltro($filtro)
	{
		$this->conectar();

		$where = $this->whereDeFiltro($filtro);

		$sql = "DELETE FROM $this->tabela $where";

		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			print_r($res);
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro em deleção no banco!");
		}
	}


	public function executar($sql)
	{
		$res = & $this->_db->query($sql);

		if(PEAR::isError($res))
		{
			$this->log("Erro","Erro na consulta ao banco classe ".strtolower(str_replace("_","",$this->tabela))."DAO");
			throw new Exception("Erro na consulta ao banco!");
		}

		return $res;
	}
}
?>
