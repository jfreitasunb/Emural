<?php

class RelaroriosBO {

	/**
	 * Neutraliza células que começam com caracteres interpretados como fórmula
	 * em planilhas (CSV Injection) e garante formato string.
	 */
	static private function sanitizarCelulaCSV($valor)
	{
		if ($valor === null) {
			return '';
		}

		$texto = (string) $valor;
		if ($texto !== '' && preg_match('/^[=+\-@\t\r]/', $texto)) {
			return "'".$texto;
		}

		return $texto;
	}

	static public function getCSVComTitulo($dados)
	{
		if($dados !== null && count($dados)) {
			$cabecalho = null;
			foreach($dados as $linha) {
				$cabecalho = $linha;
				break;
			}

			$saida = fopen('php://output', 'w');

			$colunas = array();
			foreach($cabecalho as $coluna => $value) {
				$colunas[] = self::sanitizarCelulaCSV($coluna);
			}
			fputcsv($saida, $colunas);

			foreach($dados as $linha) {
				$campos = array();
				foreach($linha as $valor) {
					$campos[] = self::sanitizarCelulaCSV($valor);
				}
				fputcsv($saida, $campos);
			}

			fclose($saida);
		}
	}

	static public function getCSV($dados)
	{
		if($dados !== null && count($dados)) {
			$saida = fopen('php://output', 'w');

			foreach($dados as $linha) {
				if(is_array($linha) && count($linha)) {
					$campos = array();
					foreach($linha as $valor) {
						$campos[] = self::sanitizarCelulaCSV($valor);
					}
					fputcsv($saida, $campos);
				} else {
					fwrite($saida, "\r\n");
				}
			}

			fclose($saida);
		}
	} 
}