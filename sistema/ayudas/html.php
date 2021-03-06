<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

use sistema\nucleo\PK_Vista as PK_Vista;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

if (!function_exists('ancla')) {
    function ancla($etiqueta = '', $link = '', $titulo = '', $clase = '')
    {
        $clase = !empty($clase) ? ' class="' . $clase . '" ' : '';
        $titulo = empty($titulo) ? $etiqueta : $titulo;

        return '<a' . $clase . ' href="' . $link . '" title="' . $titulo . '">' . $etiqueta . '</a>';
    }
}

if (!function_exists('ancla_local')) {
    function ancla_local($etiqueta = '', $link = '', $titulo = '')
    {
        $titulo = empty($titulo) ? $etiqueta : $titulo;

        return '<a href="' . url_base($link) . '" title="' . $titulo . '">' . $etiqueta . '</a>';
    }
}

if (!function_exists('navegante')) {
    function navegante($css = '')
    {
        $ol = empty($css) ? "<ol>\n" : '<ol class="' . $css . '">' . "\n";
        $lista = $ol;
        $fin = count(url_seg());
        $i = 0;
        $url = url_base() . '/';
        foreach (url_seg() as $valor) {
            ++$i;
            $url .= "$valor";
            if (!empty($valor)) {
                if ($i == $fin) {
                    $lista .= '<li class="active">' . $valor . "</li>\n";
                } else {
                    $lista .= '<li>' . ancla($valor, $url) . "</li>\n";
                }
                $url .= '/';
            }
        }
        $lista .= "</ol>\n";

        return $lista;
    }
}

if (!function_exists('visor_tabla')) {
    function visor_tabla($d = array(), $p = 'visorTabla')
    {
        $vista = PK_Vista::obt_instancia();
        $vista->sis = true;
        return $vista->ver($p, array('registros' => $d));
    }
}
