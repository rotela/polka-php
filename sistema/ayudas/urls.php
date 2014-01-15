<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
function dominio()
{
	$url=$_SERVER['HTTP_HOST'];
	return $url;
}
function url_seg($seg=0)
{
	$tg  = sistema\nucleo\PK_Config::obt_instancia();
	$cfg = $tg->obtener('aplicacion');
	$url ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$segmentos=str_replace($cfg->base_url, '', $url);
	$segmentos=explode('/', $segmentos);
	if (empty($seg))
	{
		return $segmentos;
	}
	else
	{
		foreach ($segmentos as $key => $value) {
			if (empty($value)) {
				unset($segmentos[$key]);
			}
		}
		$vacio = '';
		if (count($segmentos)>=$seg)
		{
			if (isset($segmentos[$seg]))
			{
				return $segmentos[$seg];
			}
			else
			{
				return $vacio;
			}
		}
		else
		{
			return $vacio;
		}
	}
}
function url_texto()
{
	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	return $url;
}
function url_seg_cant()
{
	$cfg = sistema\nucleo\PK_Config::obt_instancia();
	$cfg->obtener('aplicacion');
	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$segmentos=str_replace($cfg->base_url, '', $url);
	$segmentos=explode('/', $segmentos);
	foreach ($segmentos as $key => $value) {
		if (empty($value)) {
			unset($segmentos[$key]);
		}
	}
	$segmentos=count($segmentos);
	return $segmentos;
}
function base_url($agr='')
{
	$tg  = sistema\nucleo\PK_Config::obt_instancia();
	$cfg = $tg->obtener('aplicacion');
	if (empty($cfg->base_url))
	{
		$url='http://'.dominio();
	}else{
		$url=$cfg->base_url;
	}
	return empty($agr) ? $url : $url.'/'.$agr;
}
function base_ctr($value='')
{
	if (empty($value)) {
		return base_url(url_seg(1));
	}else{
		return base_url(url_seg(1).'/'.$value);
	}
}
function es_local()
{
	if (dominio()=='localhost' || dominio()=='127.0.0.1') {
		return TRUE;
	}else{
		return FALSE;
	}
}
if ( ! function_exists('redirigir'))
{
	function redirigir($url = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $url))
		{
			$url = base_url($url);
		}

		switch($method)
		{
			case 'refresh'	:
				header("Refresh:0;url=".$url);
				break;
			default	:
				header("Location: ".$url, TRUE, $http_response_code);
				break;
		}
		die();
		// exit;
	}
}
if (!function_exists('urls_amigables'))
{
	function urls_amigables($url)
	{
		// Tranformamos todo a minusculas
		$url  = strtolower($url);
		//Rememplazamos caracteres especiales latinos
		$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
		$repl = array('a', 'e', 'i', 'o', 'u', 'n');
		$url  = str_replace ($find, $repl, $url);
		// Añaadimos los guiones
		$find = array(' ', '&', '\r\n', '\n', '+');
		$url  = str_replace ($find, '-', $url);
		// Eliminamos y Reemplazamos demás caracteres especiales
		$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
		$url  = preg_replace ($find, $repl, $url);
		return $url;
	}
}