<?php

obt_ayuda('arreglos');

if (!function_exists('obt_json')) {
    function obt_json($result, $codigo = 200)
    {
        $result = convertir_utf8(objeto_array($result));
        mostrarxmljson($result, $tipo = 'json', $codigo);
    }
}

if (!function_exists('obt_xml')) {
    function obt_xml($result, $codigo = 200)
    {
        $result = convertir_utf8(objeto_array($result));
        mostrarxmljson($result, $tipo = 'xml', $codigo);
    }
}

if (!function_exists('mostrarxmljson')) {
    function mostrarxmljson($result, $tipo = 'xml', $codigo = 200)
    {
        env_cabecera($codigo, $tipo);
        if (strtolower($tipo) == 'json') {
            echo json_encode($result, JSON_NUMERIC_CHECK);
        } elseif (strtolower($tipo) == 'xml') {
            echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
            $xml_array = json_decode(json_encode($result), true);
            xmlExplorador($xml_array, 'registro');
        } else {
            echo json_encode($result, JSON_NUMERIC_CHECK);
        }
    }
}

if (!function_exists('xmlExplorador')) {
    function xmlExplorador($xml_array, $parent)
    {
        foreach ($xml_array as $tag => $value) {
            if ((int) $tag === $tag) {
                $tag = mb_substr($parent, 0, -1);
            }
            echo '<'.$tag.'>';
            if (is_array($value)) {
                xmlExplorador($value, $tag);
            } else {
                echo $value;
            }
            echo '</'.$tag.'>';
        }
    }
}

if (!function_exists('env_cabecera')) {
    function env_cabecera($codigo = 200, $tipo = 'json')
    {
        header('HTTP/1.1 '.$codigo.' '.obt_estado_envio($codigo));
        header('Content-type:application/'.$tipo.';charset=utf-8');
    }
}

if (!function_exists('obt_estado_envio')) {
    function obt_estado_envio($codigo)
    {
        $estado = array(
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            204 => 'No Content',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );

        return $estado[$codigo];
    }
}
if (!function_exists('hab_cors')) {
    function hab_cors()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
        }
    }
}
