<?php

if (!function_exists('filtrar_arreglo')) {
    function filtrar_arreglo($filtros, $arreglo)
    {
        if (is_array($filtros)) {
            if (count($filtros) > 0) {
                foreach ($filtros as $value) {
                    if (array_key_exists($value, $arreglo)) {
                        unset($arreglo[$value]);
                    }
                }
            }
        } else {
            unset($arreglo[$filtros]);
        }

        return $arreglo;
    }
}

if (!function_exists('filtrar_arreglo_con')) {
    function filtrar_arreglo_con($filtros, $arreglo)
    {
        return array_diff($arreglo, $filtros);
    }
}

if (!function_exists('obt_arreglo')) {
    function obt_arreglo($filtros, $arreglo)
    {
        if (count($filtros) > 0) {
            $nuevo = array();
            foreach ($arreglo as $clave => $v) {
                if (in_array($clave, $filtros)) {
                    $nuevo[$clave] = $v;
                }
            }
            return $nuevo;
        } else {
            return $arreglo;
        }
    }
}
if (!function_exists('convertir_utf8')) {
    function convertir_utf8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = (is_numeric($item)) ? $item : utf8_encode($item);
            }
        });

        return $array;
    }
}
if (!function_exists('decodificar_utf8')) {
    function decodificar_utf8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = (is_numeric($item)) ? $item : utf8_decode($item);
            }
        });

        return $array;
    }
}
if (!function_exists('objeto_array')) {
    function objeto_array($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }
}
if (!function_exists('array_objeto')) {
    function array_objeto($d)
    {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }
}
if (!function_exists('array_texto')) {
    function array_texto($array = array())
    {
        $t = "";
        if (is_array($array)) {
            if (count($array)>0) {
                foreach ($array as $key => $value) {
                    if (is_array($value)) {
                        array_texto($value);
                    } else {
                        $t .= (empty($t)) ? "$key : $value" : ", $key : $value";
                    }
                }
            }
        }
        return $t;
    }
}
