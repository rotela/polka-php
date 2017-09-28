<?php

if (!function_exists('cliente_ip')) {
    function cliente_ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}
if (!function_exists('cliente_nav')) {
    function cliente_nav()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}

if (!function_exists('es_ajax')) {
    function es_ajax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('es_post')) {
    function es_post()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
    }
}
if (!function_exists('es_get')) {
    function es_get()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false;
    }
}
if (!function_exists('es_metodo')) {
    function es_metodo()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

if (!function_exists('tipo_var')) {
    function is_decimal($val)
    {
        return is_numeric( $val ) && floor( $val ) != $val;
    }
    function tipo_var($var)
    {
        if (is_array($var)) {
            return 'array';
        }
        if (is_bool($var)) {
            return 'boolean';
        }
        if (is_float($var)) {
            return 'float';
        }
        if (is_double($var)) {
            return 'double';
        }
        if (is_decimal($var)) {
            return 'decimal';
        }
        if (is_int($var)) {
            return 'integer';
        }
        if (is_null($var)) {
            return 'NULL';
        }
        if (is_numeric($var)) {
            return 'numeric';
        }
        if (is_object($var)) {
            return 'object';
        }
        if (is_resource($var)) {
            return 'resource';
        }
        if (is_string($var)) {
            return 'string';
        }

        return 'unknown type';
    }
}
if (!function_exists('array_normalizar')) {
    function array_normalizar($result = array())
    {
        $elemento = array();
        foreach ($result as $key => $value) {
            if (tipo_var($value) == 'array') {
                array_push($elemento, array_normalizar($value));
            } else {
                switch (tipo_var($value)) {
                    case 'boolean':
                        $elemento[$key] = (bool) $value;
                        break;

                    case 'float':
                        $elemento[$key] = (float) $value;
                        break;

                    case 'integer':
                        $elemento[$key] = (int) $value;
                        break;

                    case 'numeric':
                        $elemento[$key] = (int) $value;
                        break;

                    case 'decimal':
                        $elemento[$key] = (double) $value;
                        break;

                    case 'double':
                        $elemento[$key] = (double) $value;
                        break;

                    case 'string':
                        $elemento[$key] = (string) $value;
                        break;

                    default:
                        $elemento[$key] = (string) $value;
                        break;
                }
            }
        }

        return $elemento;
    }
}
