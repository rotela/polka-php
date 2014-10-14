<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

use sistema\nucleo\PK_Coleccion as PK_Coleccion;

if (!function_exists('obt_dato_temp')) {

    function obt_dato_temp($clave = '') {
        $sesion = PK_Coleccion::obt_instancia()->obtener('sistema\librerias\sesion');
        return $sesion->obt_dato_temp($clave);
    }

}
if (!function_exists('obt_datos')) {

    function obt_datos($clave = '') {
        $sesion = PK_Coleccion::obt_instancia()->obtener('sistema\librerias\sesion');
        return $sesion->obt_datos($clave);
    }

}