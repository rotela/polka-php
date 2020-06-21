<?php

namespace sistema\controladores;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

use sistema\nucleo\PK_Controlador;

class Pkgen extends PK_Controlador
{
    public function __construct()
    {
        parent::__construct();
        $this->vista->sis = true;
    }

    public function principal()
    {
        $this->vista->contenido = __CLASS__;
        $this->vista->ver('index');
    }
}

/* Final de archivo pkgen.php */
/* Ubicación: ./sistema/controladores/pkgen.php */
