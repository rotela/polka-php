<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

if (!function_exists('alerta_suceso')) {
    function alerta_suceso($mensaje = '')
    {
        $ale = '<div class="alert alert-success">'."\n";
        $ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
        $ale .= $mensaje."\n";
        $ale .= '</div>'."\n";

        return $ale;
    }
}
if (!function_exists('alerta_atencion')) {
    function alerta_atencion($mensaje = '')
    {
        $ale = '<div class="alert alert-warning alert-dismissable">'."\n";
        $ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
        $ale .= $mensaje."\n";
        $ale .= '</div>'."\n";

        return $ale;
    }
}

if (!function_exists('alerta_peligro')) {
    function alerta_peligro($mensaje = '')
    {
        $ale = '<div class="alert alert-danger alert-dismissable">'."\n";
        $ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
        $ale .= $mensaje."\n";
        $ale .= '</div>'."\n";

        return $ale;
    }
}

if (!function_exists('alerta_info')) {
    function alerta_info($mensaje = '')
    {
        $ale = '<div class="alert alert-info alert-dismissable">'."\n";
        $ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
        $ale .= $mensaje."\n";
        $ale .= '</div>'."\n";

        return $ale;
    }
}
if (!function_exists('pre_arreglo')) {
    function pre_arreglo($arreglo = array())
    {
        if (count($arreglo) > 0) {
            echo '<pre>';
            print_r($arreglo);
            exit();
        }
    }
}
