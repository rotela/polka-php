<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

/**
* función que sanea una entrada de texto
* es importante usarlo para entradas de formulario o datos
* externos al sistema.
*/
if (!function_exists('sanear')) {
    function sanear($datos = '')
    {
        $entrada = array();

        if (is_object($datos)) {
            $datos = (array) $datos;
        }

        if (is_array($datos)) {
            if (count($datos) > 0) {
                foreach ($datos as $key => $value) {
                    $entrada[$key] = sanear($value);
                }
            } else {
                $entrada = $datos;
            }
        } else {
            $datos = str_replace("'", '', $datos);
            $datos = trim(stripslashes($datos));
            $datos = trim(strip_tags($datos));
            $entrada = trim($datos);
        }

        return $entrada;
    }
}
