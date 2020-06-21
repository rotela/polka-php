<?php

namespace aplicacion\librerias;

(!defined('APLICACION')) ? exit('No se permite el acceso directo al script.') : false;

class impresora
{
    public function __construct()
    {
        echo 'hola soy impresora en constructor<br>';
    }

    public function imprimir()
    {
        echo 'holaaa soy '.__CLASS__.' el metodo '.__METHOD__;
    }
}

/* Final de archivo impresora.php */
/* Ubicación: ./aplicacion/librerias/impresora.php */
