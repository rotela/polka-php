<?php
namespace aplicacion\modelos;
use sistema\nucleo\PK_Modelo as PK_Modelo;
if( ! defined('SISTEMA')) exit('No se permite acceso directo al script');
class mod_usuarios extends PK_Modelo
{
	private static $tabla='usuarios';
	public function __construct()
	{
		parent::__construct(self::$tabla);
	}
	public function obtener($offset=0,$limit=0)
	{
		$limite = empty($limit) ? '' : ' LIMIT '.$offset.', '.$limit;
		$sql = 'SELECT * FROM usuarios'.$limite;
		return $this->ejecutar($sql);
	}
}