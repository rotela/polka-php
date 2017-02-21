<?php

namespace aplicacion\modelos;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

use sistema\nucleo\PK_Modelo as PK_Modelo;

class mod_ejemplo extends PK_Modelo
{
    private static $tabla = 'nombreTuTabla';

    public function __construct()
    {
        parent::__construct(self::$tabla);
    }

    public function tufuncion()
    {
        // tu magia aquí
    }
}

/* Final de archivo mod_ejemplo.php */
/* Ubicación: ./aplicacion/modelos/mod_ejemplo.php */
