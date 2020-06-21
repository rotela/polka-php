<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('upper_sql')) {
    function upper_sql($var = '')
    {
        $a = array(
            'select',
            'first',
            'skip',
            'insert',
            'update',
            'from',
            'set',
            'values',
            'where',
            'join',
            'left',
            ' as ',
            'order',
            ' asc',
            ' desc',
            'group by',
        );

        $b = array(
            'SELECT',
            'FIRST',
            'SKIP',
            'INSERT',
            'UPDATE',
            'FROM',
            'SET',
            'VALUES',
            'WHERE',
            'JOIN',
            'LEFT',
            ' AS ',
            'ORDER',
            ' ASC ',
            ' DESC',
            'GROUP BY',
        );

        return str_replace($a, $b, $var);
    }
}

if (!function_exists('requerido')) {
    function requerido($requeridos = array(), $entradas = array(), $estricto = true)
    {
        $errores = array();
        foreach ($requeridos as $key => $value) {
            if (!array_key_exists($key, $entradas)) {
                array_push($errores, $value);
            } else {
                if ($estricto) {
                    switch (tipo_var($entradas[$key])) {
                        case 'string':
                            if (empty($entradas[$key])) {
                                array_push($errores, $value);
                            }
                            break;

                        case 'integer':
                            if ($entradas[$key] <= 0) {
                                array_push($errores, $value);
                            }
                            break;

                        case 'numeric':
                            if ($entradas[$key] <= 0) {
                                array_push($errores, $value);
                            }
                            break;

                        case 'float':
                            if ($entradas[$key] <= 0.0) {
                                array_push($errores, $value);
                            }
                            break;

                        default:
                            if (empty($entradas[$key])) {
                                array_push($errores, $value);
                            }
                            break;
                    }
                }
            }
        }

        return $errores;
    }
}
