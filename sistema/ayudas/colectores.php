<?php
if (!function_exists('obt_coleccion'))
{
	function obt_coleccion($recurso='')
	{
		return sistema\nucleo\PK_Coleccion::obtener($recurso);
	}
}
if (!function_exists('obt_config'))
{
	function obt_config($recurso='')
	{
		return sistema\nucleo\PK_Config::obtener($recurso);
	}
}
