<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
use sistema\nucleo\PK_Vista as PK_Vista;
use sistema\nucleo\PK_Config as PK_Config;

if (!function_exists('ayuda_iniciar')) {
    function ayuda_iniciar()
    {
        $config = PK_Vista::obt_instancia();
        define('SECCION', $config->obt_seccion());
        define('TEMA', $config->obt_tema());
        define('URL_VISTA', url_base('aplicacion/www/'.SECCION.'/'.TEMA.'/'));
        define('URL_CSS', URL_VISTA.'css/');
        define('URL_LESS', URL_VISTA.'less/');
        define('URL_JS', URL_VISTA.'js/');
        define('URL_IMG', URL_VISTA.'img/');
        define('URL_ICO', URL_VISTA.'ico/');
        define('URL_FONTS', URL_VISTA.'fonts/');
    }
}
if (!function_exists('obt_arc_js')) {
    function obt_arc_js()
    {
        return PK_Vista::obt_instancia()->obt_arc_js();
    }
}
if (!function_exists('obt_arc_css')) {
    function obt_arc_css()
    {
        return PK_Vista::obt_instancia()->obt_arc_css();
    }
}
if (!function_exists('vista_css')) {
    function vista_css($css = '', $pub = false)
    {
        if (!defined('URL_VISTA')) {
            ayuda_iniciar();
        }
        $carpeta = URL_CSS;
        $url = '';
        if (empty($css)) {
            $url = url_base($carpeta);
        } else {
            if ($pub) {
                $url = url_publico('css/'.$css);
            } else {
                $url_archivo = $carpeta.$css;
                $archivo = URL_VISTA.'css/'.$css;
                $archivox = str_replace($archivo, '/', SD);
                if (file_exists($archivox)) {
                    $url = $url_archivo;
                } else {
                    exit(mostrar_error('Vista', "No existe el CSS <strong>$css</strong> en: $archivo"));
                }
            }
        }

        return $url;
    }
}
if (!function_exists('vista_js')) {
    function vista_js($js = '', $pub = false)
    {
        if (!defined('URL_VISTA')) {
            ayuda_iniciar();
        }
        $carpeta = URL_JS;
        $url = '';
        if (empty($js)) {
            $url = url_base($carpeta);
        } else {
            if ($pub) {
                $url = url_publico('js/'.$js);
            } else {
                $url_archivo = $carpeta.$js;
                $archivo = URL_VISTA.'js/'.$js;
                $archivox = str_replace($archivo, '/', SD);
                if (file_exists($archivox)) {
                    $url = $url_archivo;
                } else {
                    exit(mostrar_error('Vista', "No existe el JS $js en: $archivo, Sección: ".SECCION.' Tema: '.TEMA));
                }
            }
        }

        return $url;
    }
}
if (!function_exists('vista_ico')) {
    function vista_ico($ico = '', $pub = false)
    {
        if (!defined('URL_VISTA')) {
            ayuda_iniciar();
        }
        $carpeta = URL_ICO;
        $url = '';
        if (empty($ico)) {
            $url = url_base($carpeta);
        } else {
            if ($pub) {
                $url = url_publico('ico/'.$ico);
            } else {
                $url_archivo = $carpeta.$ico;
                $archivo = URL_VISTA.'ico/'.$img;
                $archivox = str_replace($archivo, '/', SD);
                if (file_exists($archivox)) {
                    $url = $url_archivo;
                } else {
                    exit(mostrar_error('Vista', "No existe el ico <strong>$ico</strong> en: $archivo"));
                }
            }
        }

        return $url;
    }
}
if (!function_exists('vista_img')) {
    function vista_img($img = '', $pub = false)
    {
        if (!defined('URL_VISTA')) {
            ayuda_iniciar();
        }
        $carpeta = URL_IMG;
        $url = '';
        if (empty($img)) {
            $url = url_base($carpeta);
        } else {
            if ($pub) {
                $url = url_publico('img/'.$css);
            } else {
                $url_archivo = $carpeta.$img;
                $archivo = URL_VISTA.'img/'.$img;
                $archivox = str_replace($archivo, '/', SD);
                if (file_exists($archivox)) {
                    $url = $url_archivo;
                } else {
                    exit(mostrar_error('Vista', "No existe la imagen <strong>$img</strong> en: $archivo"));
                }
            }
        }

        return $url;
    }
}
if (!function_exists('vista_less')) {
    function vista_less($less = '', $pub = false)
    {
        if (!defined('URL_VISTA')) {
            ayuda_iniciar();
        }
        $carpeta = URL_LESS;
        $url = '';
        if (empty($less)) {
            $url = url_base($carpeta);
        } else {
            if ($pub) {
                $url = url_publico('less/'.$less);
            } else {
                $url_archivo = $carpeta.$less;
                $archivo = URL_VISTA.'less/'.$less;
                $archivox = str_replace($archivo, '/', SD);
                if (file_exists($archivox)) {
                    $url = $url_archivo;
                } else {
                    exit(mostrar_error('Vista', "No existe el arhchivo less <strong>$less</strong> en: $archivo"));
                }
            }
        }

        return $url;
    }
}
if (!function_exists('vista_jquery')) {
    function vista_jquery($pub = false)
    {
        if (!defined('URL_VISTA')) {
            ayuda_iniciar();
        }
        $nombre = 'jquery.js';
        $carpeta = URL_JS;
        $archivo = URL_VISTA.'js/'.$nombre;
        $url = '';

        if ($pub) {
            $url = url_publico('js/'.$nombre);
        } else {
            $archivox = str_replace($archivo, '/', SD);
            if (file_exists($archivox)) {
                $url = $archivo;
            } else {
                exit(mostrar_error('Vista', "No existe jQuery '$archivo' en la vista."));
            }
        }

        return $url;
    }
}
if (!function_exists('vista_jquery_pub')) {
    function vista_jquery_pub()
    {
        return vista_jquery(true);
    }
}
if (!function_exists('vista_capa')) {
    function vista_capa($p = '', $d = array())
    {
        return PK_Vista::obt_instancia()->capa($p, $d);
    }
}

if (!function_exists('pk_titulo')) {
    function pk_titulo()
    {
        return PK_Config::obtener('sis_principal')->titulo;
    }
}

if (!function_exists('pk_version')) {
    function pk_version()
    {
        return PK_Config::obtener('sis_principal')->version;
    }
}

if (!function_exists('ap_titulo')) {
    function ap_titulo()
    {
        return PK_Config::obtener('aplicacion')->ap_titulo;
    }
}

if (!function_exists('ap_version')) {
    function ap_version()
    {
        return PK_Config::obtener('aplicacion')->ap_version;
    }
}
if (!function_exists('ap_derechos')) {
    function ap_derechos()
    {
        return PK_Config::obtener('aplicacion')->ap_derechos;
    }
}
if (!function_exists('url_publico')) {
    function url_publico($arc = '')
    {
        $compartido = PK_Config::obtener('vistas')->compartido;
        $archivo = APLICACION.'vistas/'.$compartido.'/'.$arc;
        if (file_exists($archivo)) {
            return url_base($archivo);
        } else {
            exit(mostrar_error('Vista', "> No existe el archivo '$archivo' en la vista."));
        }
    }
}
