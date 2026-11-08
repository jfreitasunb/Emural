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

		$termos = self::interpretarFormula($formula);

		if($termos !== null && count($termos)) {
			$soma = 0;
			foreach($termos as $termo) {
				$soma += $this->peso($termo[0], $termo[1]);
			}
			$nota_final = $soma / $this->pesoTotal();
		} else {
			$nota_final = 0;
		}

		return round($nota_final,2);
	}


	/**
	 * Interpreta a fórmula armazenada em turmas.compisicao_nota, no formato
	 *   ($this->peso("Prova_1",2) + $this->peso("Lista_1",1))/$this->pesoTotal()
	 * sem executar código. Retorna uma lista de [avaliacao, peso] ou null se
	 * a fórmula não estiver exatamente nesse formato.
	 */
	public static function interpretarFormula($formula)
	{
		$formula = trim((string) $formula);

		if(!strlen($formula)) {
			return null;
		}

		$termo = '\$this->peso\("([^"\\\\$]*)",\s*(-?[0-9]+(?:\.[0-9]+)?)\)';
		$padrao = '/^\(\s*'.$termo.'(?:\s*\+\s*'.$termo.')*\s*\)\/\$this->pesoTotal\(\)$/';

		if(!preg_match($padrao, $formula)) {
			return null;
		}

		preg_match_all('/'.$termo.'/', $formula, $partes, PREG_SET_ORDER);

		$termos = array();
		foreach($partes as $parte) {
			$termos[] = array($parte[1], (float) $parte[2]);
		}

		return $termos;
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