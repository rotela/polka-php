<?php
namespace aplicacion\modelos;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
use sistema\nucleo\PK_Modelo as PK_Modelo;
class Mod_clase extends PK_Modelo
{
	private static $tabla='usuarios';
	public function __construct()
	{
		parent::__construct(self::$tabla);
	}
}
/* Final de archivo mod_clase.php */
/* Ubicación: ./aplicacion/modelos/mod_clase.php */