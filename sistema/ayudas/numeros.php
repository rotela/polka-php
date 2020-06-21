<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('normalizar_enteros')) {
    function normalizar_enteros($value = '')
    {
        return str_replace('.', '', $value);
    }
}

if (!function_exists('miles')) {
    function miles($numero = '')
    {
        return sep_miles($numero);
    }
}

if (!function_exists('sep_miles')) {
    function sep_miles($numero = '')
    {
        if (!empty($numero)) {

            $numero = intval($numero);

            $can = strlen($numero);
            if ($can <= 3) {
                return $numero;
            } else {
                $i = 0;
                $x = 0;
                $final = '';
                $numeros = str_split($numero);
                $new_num = array();
                krsort($numeros);
                foreach ($numeros as $value) {
                    if ($i === 3) {
                        $new_num[$x] = '.';
                        ++$x;
                        $new_num[$x] = $value;
                        $i = 0;
                    } else {
                        $new_num[$x] = $value;
                    }
                    ++$i;
                    ++$x;
                }
                krsort($new_num);
                foreach ($new_num as $value) {
                    $final .= $value;
                }
                return $final . "";
            }
        } else {
            return '0';
        }
    }
}
