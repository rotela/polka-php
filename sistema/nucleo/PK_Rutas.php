<?php
namespace sistema\nucleo;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
class PK_Rutas
{
	public $url_origen  = '';
	public $url_destino = '';
	public $rutas       = '';
	use PK_Singleton;
	function __construct()
	{
		$this->rutas       = PK_Config::obt_instancia()->obtener('rutas');
		$this->url_origen  = $this->ctrl_mtd();
		$this->url_destino = '';
		foreach ($this->rutas as $key => $value) {
			if ($this->url_origen == $this->quitar_arg($key)) {
				$this->url_destino = $this->quitar_arg($value);
				break;
			}
		}
	}
	public function obt_controlador()
	{
		$cadena = $this->url_destino;
		$buscar = "/";
		$resultado = strpos($cadena, $buscar);
		if($resultado !== FALSE){
			$url_array = explode('/', $cadena);
			return $url_array[0];
		}else{
			return $cadena;
		}
	}
	public function obt_metodo()
	{
		$cadena = $this->url_destino;
		$buscar = "/";
		$resultado = strpos($cadena, $buscar);
		if($resultado !== FALSE){
			$url_array = explode('/', $cadena);
			return $url_array[1];
		}else{
			return '';
		}
	}
	public function quitar_arg($url)
	{
		$url_array   = explode('/', $url);
		if (in_array('(a)', $url_array)) {
			array_pop($url_array);
		}
		$url_metho   = implode('/', $url_array);
		return $url_metho;
	}
	private function ctrl_mtd()
	{
		$url = '';
		if (isset($_GET['url'])) {
			$url         = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
			$url         = explode('/', $url);
			$url         = array_filter($url);
			$controlador = array_shift($url);
			$metodo      = array_shift($url);
			$url         = !empty($controlador) ? $controlador : '';
			$url        .= !empty($metodo) ? '/'.$metodo : '';
		}
		return $url;
	}
}