<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('seguir')) {
    function seguir($mensaje = '')
    {

        if (isset($config)) {
            if (!isset($config['seguir'])) {
                include CONFIGURACION . 'aplicacion.php';
            }
        } else {
            include CONFIGURACION . 'aplicacion.php';
        }

        if ($config['seguir']) {
            $mtime = microtime(true);
            $mtime = explode('.', $mtime);
            $ms = round($mtime[1]);
            //segundos
            $ahora = date('Y-m-d H:i:s:');
            $archivo = APLICACION . 'seguimiento' . SD . 'reporte.txt';

            $contenido = "$ahora$ms > $mensaje\n";

            if (!$gestor = fopen($archivo, 'a')) {
                exit(mostrar_error('Seguimiento', "No se puede abrir el archivo ($archivo)"));
            }
            // Escribir $contenido a nuestro archivo abierto.
            if (fwrite($gestor, $contenido) === false) {
                exit(mostrar_error('Seguimiento', "No se puede escribir en el archivo ($archivo)"));
            }
            fclose($gestor);
        }
        if (isset($config)) {
            unset($config);
        }
    }

    seguir('||| Iniciando Seguimiento |||');
}

if (!function_exists('escribrir_informe')) {
    function escribrir_informe(string $mensaje = '', $limpio = false)
    {
        $mtime = microtime(true);

        $mtime = explode('.', $mtime);
        $ms = round($mtime[1]);
        //segundos
        $ahora = date('d-m-Y H:i:s:');
        $archivo = APLICACION . 'seguimiento' . SD . 'informe.txt';
        //$mensaje = ucfirst($mensaje);
        $contenido = "$ahora$ms > $mensaje\n";
        $tipo = 'a';

        $tipo = ($limpio) ? 'w' : 'a';

        if (!$gestor = fopen($archivo, $tipo)) {
            exit(mostrar_error('Informe', "No se puede abrir el archivo ($archivo)"));
        }
        // Escribir $contenido a nuestro archivo abierto.
        if (fwrite($gestor, $contenido) === false) {
            exit(mostrar_error('Informe', "No se puede escribir en el archivo ($archivo)"));
        }
        fclose($gestor);
    }
}

if (!function_exists('crear_informe')) {
    function crear_informe(string $mensaje = '', string $archivo = '')
    {
        if (!empty($archivo)) {
            $archivo = APLICACION . 'seguimiento' . SD . $archivo;

            $contenido = "$mensaje\n";

            $tipo = 'a';

            if (!$gestor = fopen($archivo, $tipo)) {
                exit(mostrar_error('Informe', "No se puede abrir el archivo ($archivo)"));
            }
            // Escribir $contenido a nuestro archivo abierto.
            if (fwrite($gestor, $contenido) === false) {
                exit(mostrar_error('Informe', "No se puede escribir en el archivo ($archivo)"));
            }
            fclose($gestor);
        } else {
            informe('se requiere del nombre de archivo');
        }
    }
}


if (!function_exists('informe')) {
    function informe($mensaje = '')
    {
        if ($mensaje == null) {
            $mensaje = 'el informe es null';
        }
        if (is_array($mensaje)) {
            if (count($mensaje) > 0) {
                $mensaje = array_texto($mensaje);
            }
        }
        escribrir_informe($mensaje, false);
    }
}

if (!function_exists('informe_limpio')) {
    function informe_limpio($mensaje = '')
    {
        escribrir_informe($mensaje, true);
    }
}

if (!function_exists('obt_informe')) {
    function obt_informe()
    {
        $archivo = APLICACION . 'seguimiento' . SD . 'informe.txt';
        $linea = '';
        if (file_exists($archivo)) {
            $fp = fopen($archivo, "r");
            while (!feof($fp)) {
                $linea .= fgets($fp);
            }
            fclose($fp);
        } else {
            $linea = 'no existe el archivo: $archivo';
        }
        return $linea;
    }
}

if (!function_exists('limpiar_informe')) {
    function limpiar_informe()
    {
        $archivo = APLICACION . 'seguimiento' . SD . 'informe.txt';
        $linea = '';
        if (file_exists($archivo)) {
            $arch = fopen($archivo, "w+");
            fwrite($arch, "");
            fclose($arch);
        }
    }
}
