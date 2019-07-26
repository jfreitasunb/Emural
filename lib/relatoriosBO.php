<?php

class RelaroriosBO {

	static public function getCSVComTitulo($dados)
	{
		if(count($dados)) {
			foreach($dados as $linha) {
				$cabecalho = $linha;
				break;
			}

			//print_r($cabecalho);
			$print = "";
			foreach($cabecalho as $coluna => $value) {
				$print .= ',"'.$coluna.'"';
			}
			$print = substr($print,1)."\r\n";

			echo $print;

			foreach($dados as $linha) {
				echo '"'.implode('","',$linha)."\"\r\n";
			}
		}
	}

	static public function getCSV($dados)
	{
		if(count($dados)) {
			foreach($dados as $linha) {
				if(count($linha)) {
					echo '"'.implode('","',$linha)."\"\r\n";
				} else {
					echo "\r\n";
				}
			}
		}
	} 
}