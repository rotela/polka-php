<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('ejecutar')) {
    function ejecutar($sql = '', $simple = false)
    {
        if (!empty($sql)) {
            $conex = sistema\nucleo\PK_Conexion::obt_instancia();
            $inter = $conex->obt_interface();
            if ($simple) {
                $result = $inter->ejecutar($sql);
                if ($result) {
                    if (count($result) > 0) {
                        return $result[0];
                    } else {
                        return $result;
                    }
                } else {
                    return $result;
                }
            } else {
                return $inter->ejecutar($sql);
            }
        } else {
            return false;
        }
    }
}
