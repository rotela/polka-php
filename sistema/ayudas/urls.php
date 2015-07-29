<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

use sistema\nucleo\PK_Config;
use sistema\nucleo\PK_Solicitud;

function dominio() {
    return $_SERVER['HTTP_HOST'];
}

function url_solicitud() {
    $url = str_replace(url_base() . '/', '', url_texto());
    return $url;
}

function url_seg($seg = 0) {

    $tg = PK_Config::obt_instancia();
    $cfg = $tg->obtener('aplicacion');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $segmentos = str_replace($cfg->url_base, '', $url);
    $segmentos = explode('/', $segmentos);
    if (empty($seg)) {
        return $segmentos;
    } else {
        foreach ($segmentos as $key => $value) {
            if (empty($value)) {
                unset($segmentos[$key]);
            }
        }
        $vacio = '';
        if (count($segmentos) >= $seg) {
            if (isset($segmentos[$seg])) {
                return $segmentos[$seg];
            } else {
                return $vacio;
            }
        } else {
            return $vacio;
        }
    }
}

function url_texto() {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url;
}

function url_seg_cant() {
    $cfg = PK_Config::obt_instancia();
    $cfg->obtener('aplicacion');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $segmentos = str_replace($cfg->url_base, '', $url);
    $segmentos = explode('/', $segmentos);
    foreach ($segmentos as $key => $value) {
        if (empty($value)) {
            unset($segmentos[$key]);
        }
    }
    $segmentos = count($segmentos);
    return $segmentos;
}

function url_base($agr = '') {
    $tg = PK_Config::obt_instancia();
    $cfg = $tg->obtener('aplicacion');
    if (empty($cfg->url_base)) {
        $url = 'http://' . dominio();
    } else {
        $url = $cfg->url_base;
    }
    return empty($agr) ? $url : $url . $agr;
}

if(!function_exists('url_ctrl')){

    function url_ctrl($value = '') {
        $sub_carpeta = PK_Solicitud::$sub_carpeta;
        $sub_carpeta = str_replace("\\", "/", $sub_carpeta);
        $ctrl = PK_Solicitud::obt_controlador();
        if (empty($value)) {
            return empty($sub_carpeta) ? url_base($ctrl) : url_base($sub_carpeta . $ctrl);
        } else {
            return empty($sub_carpeta) ? url_base($ctrl.'/'.$value) : url_base($sub_carpeta . $ctrl . $value);
        }
    }

}
if(!function_exists('url_ctrl_solo')){

    function url_ctrl_solo($value = '') {
        $sub_carpeta = PK_Solicitud::$sub_carpeta;
        $sub_carpeta = str_replace("\\", SD, $sub_carpeta);
        $ctrl = PK_Solicitud::obt_controlador();
        if (empty($value)) {
            return empty($sub_carpeta) ? $ctrl : $sub_carpeta . $ctrl;
        } else {
            //$suburl = (url_seg(2)) ? url_seg(2) . '/' : '';
            //return empty($sub_carpeta) ? $ctrl.'/v/'.$value : url_base($sub_carpeta . $ctrl . '/n/' . $value);
            return empty($sub_carpeta) ? $ctrl.'/'.$value : $sub_carpeta . $ctrl . $value;
        }
    }

}

if (!function_exists('es_local')) {

    function es_local() {
        if (dominio() == 'localhost' || dominio() == '127.0.0.1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('redirigir')) {

    function redirigir($url = '', $method = 'location', $http_response_code = 302) {
        if (!preg_match('#^https?://#i', $url)) {
            $url = url_base($url);
        }

        switch ($method) {
            case 'refresh' :
                header("Refresh:0;url=" . $url);
                break;
            default :
                header("Location: " . $url, TRUE, $http_response_code);
                break;
        }
        die();
    }

}
if (!function_exists('url_amigable')) {

    function url_amigable($url) {
        // Tranformamos todo a minusculas
        $url = strtolower($url);
        //Rememplazamos caracteres especiales latinos
        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $url = str_replace($find, $repl, $url);
        // Añaadimos los guiones
        $find = array(' ', '&', '\r\n', '\n', '+');
        $url = str_replace($find, '-', $url);
        // Eliminamos y Reemplazamos demás caracteres especiales
        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
        $repl = array('', '-', '');
        $url = preg_replace($find, $repl, $url);
        return $url;
    }

}