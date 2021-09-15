<?php

class calcularMediaBO
{
	private $notas;
	private $pesos;

	function __construct()
	{
		$this->pesos = 0;
		$this->notas = null;
	}


	public function executar($formula, $notas)
	{
		$nota_final = 0;
		$this->notas = $notas;

		if(strlen($formula)){
			eval("\$nota_final = ".$formula.";");
		} else {
			$nota_final = 0;
		}

		return round($nota_final,2);
	}


	private function peso($prova, $peso = 0)
	{
		$this->pesos += $peso;
		if(isset($this->notas[$prova]))
			return $this->notas[$prova] * $peso;
		else
			return 0;
	}


	private function pesoTotal()
	{
		if($this->pesos > 0)
			return $this->pesos;
		return 1;
	}
}
?>