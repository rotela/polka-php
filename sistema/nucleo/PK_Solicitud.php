<?php
namespace sistema\nucleo;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
class PK_Solicitud
{
	private static $controlador = '';
	private static $metodo      = '';
	private static $argumentos  = array();
	use PK_Singleton;
	private static function configurar()
	{
		$ruta        = new PK_Rutas();
		$controlador = $ruta->obt_controlador();
		$metodo      = $ruta->obt_metodo();
		if (isset($_GET['url'])) {
			$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			$url = array_filter($url);
			if (empty($controlador)) {
				self::$controlador = array_shift($url);
			}else{
				array_shift($url);
				self::$controlador = $controlador;
			}
			if (empty($metodo)) {
				self::$metodo = array_shift($url);
			}else{
				array_shift($url);
				self::$metodo = $metodo;
			}
			self::$argumentos  = $url;
		}
	}
	public static function obt_controlador()
	{
		if (empty(self::$controlador)) self::configurar();
		return self::$controlador;
	}
	public static function obt_metodo()
	{
		if (empty(self::$metodo)) self::configurar();
		return self::$metodo;
	}
	public static function obt_argumentos()
	{
		if (empty(self::$argumentos)) self::configurar();
		return self::$argumentos;
	}
}