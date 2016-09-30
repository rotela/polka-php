<?php

namespace aplicacion\librerias;

if (!defined('SISTEMA')) {
    exit('No se permite acceso directo al script');
}

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
