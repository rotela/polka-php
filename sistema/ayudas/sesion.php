<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
use sistema\nucleo\PK_Coleccion as PK_Coleccion;
if (!function_exists('obt_alerta')) {
	function obt_alerta($clave='')
	{
		$sesion = PK_Coleccion::obtener('sistema\librerias\sesion');
		return $sesion->obt_alerta($clave);
	}
}