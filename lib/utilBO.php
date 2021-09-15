<?php

class UtilBO
{
	static function compararDatas($data1,$data2 = null)
	{
		if($data2 === null) {
			$data2 = date("d/m/Y");
		}
		$data_extencao1 = explode("/",$data1);
		$data_extencao2 = explode("/",$data2);

		$d1 = 0;
		if(count($data_extencao1) == 3) {
			$d1 = $data_extencao1[2] * 10000 + $data_extencao1[1] * 100 + $data_extencao1[0] * 1;
		}
		$d2 = $data_extencao2[2] * 10000 + $data_extencao2[1] * 100 + $data_extencao2[0] * 1;

		if($d1 < $d2) {
			return -1;
		} else if ($d1 > $d2) {
			return 1;
		} else {
			return 0;
		}
	}


	static function getDataPadraoISO($data_padrao_brasileiro, $separador = "/")
	{
		$data = explode($separador,$data_padrao_brasileiro);

		return $data[2]."-".$data[1]."-".$data[0];
	}


	static function getDataPadraoAmericano($data_padrao_brasileiro, $separador = "/")
	{
		$data = explode($separador,$data_padrao_brasileiro);

		return $data[1]."-".$data[0]."-".$data[2];
	}


	static function getDataPadraoBrasileiro($data_padrao_americano, $separador = "-")
	{
		$data = explode($separador,$data_padrao_americano);

		return $data[1]."/".$data[0]."/".$data[2];
	}
}