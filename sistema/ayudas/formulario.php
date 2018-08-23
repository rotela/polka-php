<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('agr_selector')) {
    function agr_selector($nombre, $opciones, $id = '', $seleccion = '', $extra = '')
    {
        $pk = obt_coleccion('sistema\librerias\formux');
        $pk->agr_selector($nombre, $opciones, $id, $seleccion, $extra);
        $combo = $pk->generar();
        $pk->limpiar_cache();

        return $combo;
    }
}
if (!function_exists('obt_valor')) {
    function obt_valor($nom = '', $xdef = '')
    {
        if (isset($_POST[$nom])) {
            return $_POST[$nom];
        } else {
            if (!empty($xdef)) {
                return $xdef;
            } else {
                return '';
            }
        }
    }
}
if (!function_exists('obt_error')) {
    function obt_error($clave)
    {
        $pk = obt_coleccion('sistema\librerias\formulario');
        return $pk->error($clave);
    }
}
if (!function_exists('obt_errores')) {
    function obt_errores()
    {
        $pk = obt_coleccion('sistema\librerias\formulario');
        return $pk->errores();
    }
}
if (!function_exists('buscar_errores')) {
    function buscar_errores()
    {
        $errores = obt_errores();
        $mx = '';
        if ($errores) {
            foreach ($errores as $value) {
                $mx .= alerta_peligro($value);
            }
        }
        return $mx;
    }
}
if (!function_exists('obt_csrf')) {
    function obt_csrf()
    {
        $sesion = obt_coleccion('sistema\librerias\sesion');
        $sesion->borrar_csrf();
        $sesion->env_csrf();

        $csrf_nom = obt_config('aplicacion')->csrf_nom;
        $token = $sesion->obt_datos($csrf_nom);
        $campo = '<input type="hidden" name="'.$csrf_nom.'" id="'.$csrf_nom.'" value="'.$token.'">'."\n";

        return $campo;
    }
}
