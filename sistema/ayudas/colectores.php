<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('obt_instancia')) {
    function obt_instancia()
    {
        global $obj_controlador;
        $pk = &$obj_controlador;
        return $pk;
    }
}

if (!function_exists('obt_coleccion')) {
    function obt_coleccion($recurso = '')
    {
        return sistema\nucleo\PK_Coleccion::obt_instancia()->obtener($recurso);
    }
}

if (!function_exists('obt_config')) {
    function obt_config($recurso = '')
    {
        return sistema\nucleo\PK_Config::obt_instancia()->obtener($recurso);
    }
}

if (!function_exists('obt_ayuda')) {
    function obt_ayuda($ayuda = '')
    {
        $carpeta = AYUDAS;
        $archivo = $carpeta . agr_ext($ayuda);
        // si existe la ayuda,
        if (file_exists($archivo)) {
            // incluirla, o,
            include_once $archivo;
        } else {
            $carpeta = SIS_AYUDAS;
            $archivo = $carpeta . agr_ext($ayuda);
            // incluirla
            if (file_exists($archivo)) {
                include_once $archivo;
            } else {
                exit(mostrar_error('Ayudas', 'No existe el archivo de ayuda ' . $ayuda));
            }
        }
    }
}
