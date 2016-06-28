<?php

if (!function_exists('sanear')) {

    function sanear($datos = '') {
        $entrada = array();

        if (is_object($datos))
            $datos = (array) $datos;

        if (is_array($datos)) {
            if (count($datos) > 0) {
                foreach ($datos as $key => $value) {
                    $entrada[$key] = sanear($value);
                }
            } else {
                $entrada = $datos;
            }
        } else {
            // quitamos las barras de un string con comillas escapadas,
            // aunque actualmente se desaconseja su uso, muchos servidores
            // las tienen activadas. Cuando ésta extensión está activada, php
            // añade automáticamente caracteres válidos.
            if (get_magic_quotes_gpc())
                $datos = trim(stripslashes($datos));
            // eliminados etiquetas html y php
            $datos = strip_tags($datos);
            // convertimos todos los caracteres aplicables a entidades html
            // $datos = htmlentities($datos);
            $entrada = trim($datos);
        }
        return $entrada;
    }

}
