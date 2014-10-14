<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
if (!function_exists('candado_abrir'))
{
	function candado_abrir($valor='')
	{
		$candado = obt_coleccion('sistema\librerias\candado');
		return $candado->abrir($valor);
	}
}
if (!function_exists('candado_cerrar'))
{
	function candado_cerrar($valor='')
	{
		$candado = obt_coleccion('sistema\librerias\candado');
		return $candado->cerrar($valor);
	}
}