<?php
namespace aplicacion\controladores;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
use sistema\nucleo\PK_Controlador as PK_Controlador;
class Bienvenido extends PK_Controlador
{
	function __construct()
	{
		parent::__construct();
	}
	function principal()
	{
		$this->ayudas('html');
		$this->vista->ver('bienvenido');
	}
}