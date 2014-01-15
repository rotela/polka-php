<?php
namespace aplicacion\modelos;
use sistema\nucleo\PK_Modelo as PK_Modelo;
if( ! defined('SISTEMA')) exit('No se permite acceso directo al script');
class mod_seccion extends PK_Modelo
{
	private static $tabla = 'seccion';
	public function __construct()
	{
		parent::__construct(self::$tabla);
	}
	public function listar($offset=0,$limit=0)
	{
		return $this->ejecutar('select * from seccion');
		// $this->seleccionar()->desde()->limite($offset,$limit);
		// return $this->obtener();
	}
	public function datos_combo()
	{
		$this->seleccionar(array('idsec','seccion_nombre'))->desde('seccion');
		return $this->obtener(false);
	}
}