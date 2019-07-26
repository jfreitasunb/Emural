<?php

require_once $ROOT_PATH.'persistencia/dao.php';

class SIDAO extends DAO
{
	private $mapaAtributosUsuario;
	private $mapaAtributosTurma;
	private $mapaAtributosDisciplilasMagistrais;

	function __construct()
	{
		$this->mapaAtributosUsuario["coduser"] = "users.coduser";
		$this->mapaAtributosUsuario["tipo"] = "users.tipo_users";
		$this->mapaAtributosUsuario["nome"] = "(coalesce((users.name),'') || ' ' || coalesce((users.firstname),''))";
		$this->mapaAtributosUsuario["usuario"] = "unix.login";
		$this->mapaAtributosUsuario["senha"] = "unix.passwd";

		$this->mapaAtributosTurma["codigo_cpd"] = "disciplinas_mat.codigo";
		$this->mapaAtributosTurma["disciplina_descricao"] = "disciplinas_mat.nome";
		$this->mapaAtributosTurma["creditos"] = "disciplinas_mat.creditos";
		$this->mapaAtributosTurma["descricao"] = "oferta_lista_de_ofertas.turma";
		$this->mapaAtributosTurma["periodo"] = "oferta_lista_de_ofertas.turno";
//		$this->mapaAtributosTurma["sala"] = "oferta_lista_de_ofertas.salas";
		$this->mapaAtributosTurma["professor"] = "oferta_lista_de_ofertas.professor";
		$this->mapaAtributosTurma["semestre"] = "oferta_lista_de_ofertas.semestre";
		$this->mapaAtributosTurma["ano"] = "oferta_lista_de_ofertas.ano";

		$this->mapaAtributosDisciplilasMagistrais["codigo_cpd"] = "disciplinas_mat.codigo";
		$this->mapaAtributosDisciplilasMagistrais["disciplina_descricao"] = "disciplinas_mat.nome";
		$this->mapaAtributosDisciplilasMagistrais["creditos"] = "disciplinas_mat.creditos";
		$this->mapaAtributosDisciplilasMagistrais["semestre"] = "oferta_disciplinas_magistral.semestre";
		$this->mapaAtributosDisciplilasMagistrais["ano"] = "oferta_disciplinas_magistral.ano";
	}


	public function recuperaDeUsuario($filtro, $ordemarray = null)
	{
		GLOBAL $BANCOSI;

		$this->conectar($BANCOSI);

		$where = $this->whereDeFiltro($filtro, $this->mapaAtributosUsuario);

		$ordem = $this->orderBy($ordemarray, $this->mapaAtributosUsuario);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosUsuario)."
				FROM users INNER JOIN unix ON unix.coduser = users.coduser
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


	public function recuperaDeTurma($filtro, $ordemarray = null)
	{
		GLOBAL $BANCOSI;

		$this->conectar($BANCOSI);

		$where = $this->whereDeFiltro($filtro, $this->mapaAtributosTurma);

		$ordem = $this->orderBy($ordemarray, $this->mapaAtributosTurma);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosTurma)."
				FROM (oferta_lista_de_ofertas
						INNER JOIN disciplinas_mat ON oferta_lista_de_ofertas.disciplina = disciplinas_mat.codigo)
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


	public function recuperaDeDisciplinasMagistrais($filtro, $ordemarray = null)
	{
		GLOBAL $BANCOSI;

		$this->conectar($BANCOSI);

		$where = $this->whereDeFiltro($filtro, $this->mapaAtributosDisciplilasMagistrais);

		$ordem = $this->orderBy($ordemarray, $this->mapaAtributosDisciplilasMagistrais);

		$sql = "SELECT ".$this->atributosSelect($this->mapaAtributosDisciplilasMagistrais)."
				FROM (oferta_disciplinas_magistral
						INNER JOIN disciplinas_mat ON oferta_disciplinas_magistral.codigo = disciplinas_mat.codigo)
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


	public function deletaDeFiltro($filtro) {
		throw new Exception("Não é permitido deletar dados no SI.");
	}


	public function executar($sql) {
		throw new Exception("Não é permitido executar script no SI.");
	}


	public function inserir($insert) {
		throw new Exception("Nào é permitido inserir dados no SI.");
	}


	public function updateCamposDeFiltro($campos,$filtro) {
		throw new Exception("Nào é permitido atualizar dados no SI.");
	}
}
?>
