<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
use sistema\nucleo\PK_Coleccion as PK_Coleccion;
use sistema\nucleo\PK_Controlador as PK_Controlador;

if (!function_exists('agr_selector')) {
	function agr_selector($nombre,$opciones,$id='',$seleccion='',$extra='')
	{
		$pk = PK_Controlador::obt_instancia();
		$pk->librerias('formux');
		$pk->formux->agr_selector($nombre,$opciones,$id,$seleccion,$extra);
		$combo = $pk->formux->generar();
		$pk->formux->limpiar_cache();
		return $combo;
	}
}
if (!function_exists('obt_valor')) {
	function obt_valor($nom='',$xdef='')
	{
		if (isset($_POST[$nom])) {
			return $_POST[$nom];
		}else{
			if (!empty($xdef)) {
				return $xdef;
			}else{
				return '';
			}
		}
	}
}
if (!function_exists('obt_error')) {
	function obt_error($clave)
	{
		$pk = PK_Coleccion::obtener('sistema\librerias\formulario');
		return $pk->error($clave);
	}
}
if (!function_exists('obt_errores')) {
	function obt_errores()
	{
		$pk = PK_Coleccion::obtener('sistema\librerias\formulario');
		return $pk->errores();
	}
}
if (!function_exists('obt_csrf')) {
	function obt_csrf(){
		$csrf_nom = obt_config('aplicacion')->csrf_nom;
		$token    = obt_coleccion('sistema\librerias\sesion')->obt_datos($csrf_nom);
		$campo    = '<input type="hidden" name="'.$csrf_nom.'" id="'.$csrf_nom.'" value="'.$token.'">';
		return $campo;
	}
}