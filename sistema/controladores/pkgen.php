<?php
namespace sistema\controladores;
if(!defined('SISTEMA')) exit('No se permite acceso directo al script');
use sistema\nucleo\PK_Controlador;
class Pkgen extends PK_Controlador
{
	function __construct()
	{
		parent::__construct();
		$this->vista->sis = TRUE;
	}
	public function principal()
	{
		$this->vista->contenido = __CLASS__;
		$this->vista->ver('index');
	}
}
/* Final de archivo pkgen.php */
/* Ubicación: ./sistema/controladores/pkgen.php */