<?php

namespace aplicacion\modelos;

(!defined('APLICACION')) ? exit('No se permite el acceso directo al script.') : false;

use sistema\nucleo\PK_Modelo as PK_Modelo;

class mod_usuarios extends PK_Modelo
{
    private static $tabla = 'usuarios';

    public function __construct()
    {
        parent::__construct(self::$tabla, 'idusuario');
    }

    public function tufuncion()
    {
        // tu magia aquí
    }
}

/* Final de archivo mod_usuarios.php */
/* Ubicación: ./aplicacion/modelos/mod_usuarios.php */
