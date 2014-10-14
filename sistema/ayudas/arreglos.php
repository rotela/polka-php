<?php

if (!function_exists('filtrar_arreglo')) {

    function filtrar_arreglo($filtros = array(), $arreglo) {
        if (count($filtros) > 0) {
            foreach ($filtros as $value) {
                unset($arreglo[$value]);
            }
        }
        return $arreglo;
    }

}
if (!function_exists('filtrar_arreglo_con')) {

    function filtrar_arreglo_con($filtros = array(), $arreglo) {
        return array_diff($arreglo, $filtros);
    }

}
if (!function_exists('obt_arreglo')) {

    function obt_arreglo($filtros = array(), $arreglo) {
        $nuevo = array();
        if (count($filtros) > 0) {
            foreach ($filtros as $value) {
                if (array_key_exists($value, $arreglo)) {
                    $nuevo[$value] = $arreglo[$value];
                }
            }
            return $nuevo;
        } else {
            return $arreglo;
        }
    }

}
