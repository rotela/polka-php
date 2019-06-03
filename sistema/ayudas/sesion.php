<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

use sistema\nucleo\PK_Coleccion as PK_Coleccion;

if (!function_exists('sesion_obt_dato_temp')) {
    function sesion_obt_dato_temp($clave = '')
    {
        $sesion = PK_Coleccion::obt_instancia()->obtener('sistema\librerias\sesion');
        return $sesion->obt_dato_temp($clave);
    }
}

if (!function_exists('sesion_env_dato_temp')) {
    function sesion_env_dato_temp($mensaje, $clave = '')
    {
        $sesion = PK_Coleccion::obt_instancia()->obtener('sistema\librerias\sesion');
        return $sesion->env_dato_temp($mensaje, $clave);
    }
}

if (!function_exists('sesion_env_datos')) {
    function sesion_env_datos($datos, $clave = '')
    {
        $sesion = PK_Coleccion::obt_instancia()->obtener('sistema\librerias\sesion');
        return $sesion->env_datos($datos, $clave = '');
    }
}

if (!function_exists('sesion_obt_datos')) {
    function sesion_obt_datos($clave = '')
    {
        $sesion = PK_Coleccion::obt_instancia()->obtener('sistema\librerias\sesion');
        return $sesion->obt_datos($clave);
    }
}

if (!function_exists('sesion_destruir')) {
    function sesion_destruir()
    {
        session_destroy();
    }
}
