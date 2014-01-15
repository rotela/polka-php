<?php
namespace aplicacion\modelos;
use sistema\nucleo\PK_Modelo as PK_Modelo;
if( ! defined('SISTEMA')) exit('No se permite acceso directo al script');
class mod_menus extends PK_Modelo
{
	private static $tabla='menus';
	public function __construct()
	{
		parent::__construct(self::$tabla);
	}
	public function listar($offset=0,$limit=0,$objecto=TRUE)
	{
		$limite = empty($limit) ? '' : ' LIMIT '.$offset.', '.$limit;
		$sql = 'SELECT * FROM menus'.$limite;
		return $this->ejecutar($sql,$objecto);
	}
	public function datos_combo()
	{
		$this->seleccionar(array('idmen','menu_etiqueta'))->desde('menus');
		return $this->obtener(false);
	}
}