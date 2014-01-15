<?php
namespace aplicacion\modelos;
use sistema\nucleo\PK_Modelo as PK_Modelo;
if( ! defined('SISTEMA')) exit('No se permite acceso directo al script');
class mod_submenus extends PK_Modelo
{
	private static $tabla='submenus';
	public function __construct()
	{
		parent::__construct(self::$tabla);
	}
	public function listar($offset=0,$limit=0)
	{
		$this->seleccionar()->desde('submenus');
		$this->unir('menus','submenus.idmen=menus.idmen');
		$this->limite($offset,$limit);
		return $this->obtener();
	}
}