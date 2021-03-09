<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('cliente_ip')) {
    function cliente_ip()
    {
        $local = isset($_SERVER["HTTP_X_REAL_IP"]) ? $_SERVER["HTTP_X_REAL_IP"] : '127.0.0.1';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return ($_SERVER['REMOTE_ADDR'] == '::1') ? $local : $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return ($_SERVER['REMOTE_ADDR'] == '::1') ? $local : $_SERVER['REMOTE_ADDR'];
        }
    }
}

if (!function_exists('es_proxy')) {
    function es_proxy()
    {
        return isset($_SERVER["HTTP_X_FORWARDED_FOR"]);
    }
}

if (!function_exists('cliente_nav')) {
    function cliente_nav()
    {
        $nav = obt_navegador();
        $res = 'nav: ' . $nav['name'] . ', ver: ' . $nav['version'] . ', so:' . $nav['platform'];
        return $res;
    }
}

if (!function_exists('obt_navegador')) {
    function obt_navegador()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Desconocido';
        $ub = '';
        $platform = 'Desconocido';
        $version = "";
        $mobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $u_agent);

        // primero tenemos la plataforma
        if (preg_match('/linux/i', $u_agent) && !$mobile) {
            $platform = 'linux';
        } elseif ($mobile) {
            $platform = 'android';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Luego obtenga el nombre del agente de uso sí por separado y por una buena razón
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Explorer/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finalmente obtenemos la versión correcta
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // solo continuamos
        }

        if (is_array($matches)) {
            // vemos cuanto tenemos
            $i = count($matches['browser']);
            if ($i !== 1) {
                // tendremos dos ya que todavía no estamos usando el argumento 'otro'.
                // ver si la versión es anterior o posterior al nombre
                if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                    $version = (count($matches['version']) > 0) ? $matches['version'][0] : '0';
                } else {
                    $version = (count($matches['version']) > 0) ? $matches['version'][1] : '0';
                }
            } else {
                $version = $matches['version'][0];
            }
        } else {
            $version = $matches['version'][0];
        }

        // chekeamos si tenemos numero
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern,
        );
    }
}

if (!function_exists('es_ajax')) {
    function es_ajax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ||
                $_SERVER['HTTP_X_REQUESTED_WITH'] == 'X-Requested-With' ||
                $_SERVER['X-Requested-With'] == 'X-Requested-With'
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            $headers = apache_request_headers();
            if (isset($headers['X-Requested-With'])) {
                if (
                    strtolower($headers['X-Requested-With']) == 'xmlhttprequest' ||
                    $headers['HTTP_X_REQUESTED_WITH'] == 'X-Requested-With' ||
                    $headers['X-Requested-With'] == 'X-Requested-With'
                ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
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
        return is_numeric($val) && floor($val) != $val;
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

        return 'desconocido';
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
                        $elemento[$key] = (float) $value;
                        break;

                    case 'double':
                        $elemento[$key] = (float) $value;
                        break;

                    case 'string':
                        $elemento[$key] = (string) $value;
                        break;

                    default:
                        $elemento[$key] = $value;
                        break;
                }
            }
        }

        return $elemento;
    }
}

if (!function_exists('obt_entradas')) {
    function obt_entradas()
    {
        return obt_entradas_peticion();
    }
}

if (!function_exists('obt_entradas_peticion')) {
    function obt_entradas_peticion()
    {
        obt_ayuda('limpiador');
        $entradas = array();
        $texto = html_entity_decode(@file_get_contents('php://input'), ENT_QUOTES, 'UTF-8');

        switch (es_metodo()) {
            case 'POST':
                if (count($_POST) > 0) {
                    $entradas = array_merge($entradas, $_POST);
                } else {
                    $otros = (array) json_decode($texto);

                    if (count($otros) > 0) {
                        $entradas = array_merge($entradas, $otros);
                    }
                }
                break;

            case 'GET':
                $entradas = array_merge($entradas, $_GET);
                break;

            case 'PUT':
                $otros = (array) json_decode($texto);

                if (count($otros) > 0) {
                    $entradas = array_merge($entradas, $otros);
                } else {
                    parse_str($texto, $entradas);
                }
                $entradas = array_merge($entradas, $_GET);
                break;

            default:
                $otros = (array) $texto;
                if (count($otros) > 0) {
                    $entradas = array_merge($entradas, $otros);
                }
                break;
        }
        if (isset($entradas['url'])) {
            unset($entradas['url']);
        }
        $entradas = array_normalizar($entradas);

        $entradas = sanear($entradas);

        return $entradas;
    }
}

if (!function_exists('bytes_a')) {
    function bytes_a($bytes = 0)
    {
        $tipo = array("", "Kilo", "Mega", "Giga", "Tera", "Peta", "Exa", "Zetta", "Yotta");
        $index = 0;
        while ($bytes >= 1024) {
            $bytes /= 1024;
            $index++;
        }
        return ("" . round($bytes, 2) . " " . $tipo[$index] . "Bytes");
    }
}
