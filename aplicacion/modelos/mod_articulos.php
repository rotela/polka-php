<?php
namespace aplicacion\modelos;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
use sistema\nucleo\PK_Modelo as PK_Modelo;
class Mod_articulos extends PK_Modelo
{
	private static $tabla='articulos';
	public function __construct()
	{
		parent::__construct(self::$tabla);
	}
	public function listar($offset=0,$limit=0,$filtro='')
	{
		$this->seleccionar()->desde('articulos')->unir('seccion','articulos.idsec=seccion.idsec');
		return $this->mientras($filtro)->limite($offset,$limit)->obtener();
	}
}

/* Final de archivo mod_articulos.php */
/* Ubicación: ./aplicacion/modelos/mod_articulos.php */