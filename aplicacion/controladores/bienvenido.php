<?php

namespace aplicacion\controladores;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
use sistema\nucleo\PK_Controlador as PK_Controlador;

class bienvenido extends PK_Controlador
{
    public function __construct()
    {
        parent::__construct();
    }
    public function principal()
    {
        /* envío una vista al navegador */
        $this->vista->ver('index');
    }
}
