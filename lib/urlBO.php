<?php

class URLBO {

	function codigoSegundoNivel()
	{
		global $ROOT;

		$uri = str_replace($ROOT,"/",$_SERVER["REQUEST_URI"]);

		$pedacos = explode("/", $uri);

		$url = new stdClass();

		if(isset($pedacos[2])) {
			$url->codigo = $pedacos[2];

			if(strpos($url->codigo, ".") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "."));

			if(strpos($url->codigo, "#") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "#"));

			if(strpos($url->codigo, "?") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "?"));
		} else {
			$url->codigo = 0;
		}

		return $url;
	}

	function codigoTerceiroNivel()
	{
		global $ROOT;

		$uri = str_replace($ROOT,"/",$_SERVER["REQUEST_URI"]);

		$pedacos = explode("/", $uri);

		$url = new stdClass();

		if(isset($pedacos[3])) {
			$url->codigo = $pedacos[3];

			if(strpos($url->codigo, ".") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "."));

			if(strpos($url->codigo, "#") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "#"));

			if(strpos($url->codigo, "?") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "?"));
		} else {
			$url->codigo = 0;
		}

		return $url;
	}

	function codigoSegundoTerceiroNivel()
	{
		global $ROOT;

		$uri = str_replace($ROOT,"/",$_SERVER["REQUEST_URI"]);

		$pedacos = explode("/", $uri);

		$url = new stdClass();

		if(isset($pedacos[2])) {
			$url->codigo = $pedacos[2];

			if(strpos($url->codigo, ".") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "."));

			if(strpos($url->codigo, "#") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "#"));

			if(strpos($url->codigo, "?") !== false)
				$url->codigo = substr($url->codigo,0,strpos($url->codigo, "?"));

			if(isset($pedacos[3])) {
				$url->codigo2 = $pedacos[3];

				if(strpos($url->codigo2, ".") !== false)
					$url->codigo2 = substr($url->codigo2,0,strpos($url->codigo2, "."));

				if(strpos($url->codigo2, "#") !== false)
					$url->codigo2 = substr($url->codigo2,0,strpos($url->codigo2, "#"));

				if(strpos($url->codigo2, "?") !== false)
					$url->codigo2 = substr($url->codigo2,0,strpos($url->codigo2, "?"));
			} else {
				$url->codigo2 = 0;
			}
		} else {
			$url->codigo = 0;
		}

		if (isset($_GET["d"])) {
			$url->deletar = true;
		} else {
			$url->deletar = false;
		}

		return $url;
	}

	public function receberAlertas()
	{
		global $ALERTAS;

		foreach ($_GET as $key => $value) {
			if(strpos($key, "NOTY_") !== false) {
				$ALERTAS[substr($key,5)] = "";
			}
		}
	}

	function informacoesGet()
	{
		$url = & new stdClass();

		if(isset($_GET)) {
			foreach ($_GET as $chave => $valor) {
				$url->$chave = $valor;
			}
		}

		return $url;
	}
}
?>