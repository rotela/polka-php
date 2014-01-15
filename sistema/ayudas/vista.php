<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
use sistema\nucleo\PK_Vista as PK_Vista;
use sistema\nucleo\PK_Config as PK_Config;
if (!function_exists('ayuda_iniciar')) {
	function ayuda_iniciar()
	{
		$seccion = PK_Vista::obt_instancia()->obt_seccion();
		$tema    = PK_Vista::obt_instancia()->obt_tema();
		$url     = base_url('aplicacion/vistas/'.$seccion.'/'.$tema.'/');
		define("URL_VISTA", $url);
		define("URL_CSS", URL_VISTA."css/");
		define("URL_JS", URL_VISTA."js/");
		define("URL_IMG", URL_VISTA."img/");
		define("URL_ICO", URL_VISTA."ico/");
		define("URL_FONTS", URL_VISTA."fonts/");
		define("VISTAS", APLICACION.'vistas'.SD.$seccion.SD.$tema.SD);
	}
}
if (!function_exists('obt_arch_js')) {
	function obt_arch_js()
	{
		return PK_Vista::obt_instancia()->obt_arch_js();
	}
}
if (!function_exists('vista_css')) {
	function vista_css($css='')
	{
		if (!defined('VISTAS')) { ayuda_iniciar(); }
		$carpeta = URL_CSS;
		if (empty($css))
		{
			return base_url($carpeta);
		}
		else
		{
			$url_archivo = $carpeta.$css;
			$archivo     = VISTAS.'css'.SD.$css;
			if (file_exists($archivo))
			{
				return $url_archivo;
			}
			else
			{
				exit(mostrar_error('Vista',"No existe el CSS <strong>$css</strong> en: $archivo"));
			}
		}
	}
}
if (!function_exists('vista_js')) {
	function vista_js($js='')
	{
		if (!defined('VISTAS')) { ayuda_iniciar(); }
		$carpeta = URL_JS;
		if (empty($js)) {
			return base_url($carpeta);
		}else{
			$url_archivo = $carpeta.$js;
			$archivo     = VISTAS.'js'.SD.$js;
			if (file_exists($archivo)) {
				return $url_archivo;
			}else{
				exit(mostrar_error('Vista',"No existe el JS $js en: $archivo"));
			}
		}
	}
}
if (!function_exists('vista_ico')) {
	function vista_ico($ico='')
	{
		if (!defined('VISTAS')) { ayuda_iniciar(); }
		$carpeta=URL_ICO;
		if (empty($ico)) {
			return base_url($carpeta);
		}else{
			$url_archivo = $carpeta.$ico;
			$archivo     = VISTAS.'ico'.SD.$img;
			if (file_exists($archivo)) {
				return $url_archivo;
			}else{
				exit(mostrar_error('Vista',"No existe el ico <strong>$ico</strong> en: $archivo"));
			}
		}
	}
}
if (!function_exists('vista_img')) {
	function vista_img($img='')
	{
		if (!defined('VISTAS')) { ayuda_iniciar(); }
		$carpeta = URL_IMG;
		if (empty($img)) {
			return base_url($carpeta);
		}else{
			$url_archivo = $carpeta.$img;
			$archivo = VISTAS.'img'.SD.$img;
			if (file_exists($archivo)) {
				return $url_archivo;
			}else{
				exit(mostrar_error('Vista',"No existe la imagen <strong>$img</strong> en: $archivo"));
			}
		}
	}
}
if (!function_exists('vista_jq')) {
	function vista_jq()
	{
		if (!defined('VISTAS')) { ayuda_iniciar(); }
		$nombre='jquery.js';
		$carpeta=URL_JS;
		$archivo=$carpeta.$nombre;
		if (file_exists(VISTAS.'/js/'.$nombre)) {
			return $archivo;
		}else{
			exit(mostrar_error('Vista',"No existe jQuery '$nombre' en la vista."));
		}
	}
}

if (!function_exists('vista_ver'))
{
	function vista_capa($p='',$d=array())
	{
		return PK_Vista::obt_instancia()->capa($p);
	}
}

if (!function_exists('pk_titulo'))
{
	function pk_titulo()
	{
		return PK_Config::obtener('sis_principal')->titulo;
	}
}

if (!function_exists('pk_version'))
{
	function pk_version()
	{
		return PK_Config::obtener('sis_principal')->version;
	}
}