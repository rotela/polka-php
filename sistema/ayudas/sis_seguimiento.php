<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

if (!function_exists('seguir')) {
    function seguir($mensaje = '')
    {
        if (!isset($config['seguir'])) {
            include CONFIGURACION.'aplicacion.php';
        }
        if ($config['seguir']) {
            $mtime = microtime(true);
            $mtime = explode('.', $mtime);
            $ms = round($mtime[1]);
            //segundos
            $ahora = date('Y-m-d H:i:s:');
            $archivo = APLICACION.'seguimiento'.SD.'reporte.txt';
            $mensaje = ucfirst($mensaje);
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

if (!function_exists('informe')) {
    function informe($mensaje = '')
    {
        $mtime = microtime(true);
        $mtime = explode('.', $mtime);
        $ms = round($mtime[1]);
        //segundos
        $ahora = date('Y-m-d H:i:s:');
        $archivo = APLICACION.'seguimiento'.SD.'informe.txt';
        $mensaje = ucfirst($mensaje);
        $contenido = "$ahora$ms > $mensaje\n";

        if (!$gestor = fopen($archivo, 'a')) {
            exit(mostrar_error('Informe', "No se puede abrir el archivo ($archivo)"));
        }
        // Escribir $contenido a nuestro archivo abierto.
        if (fwrite($gestor, $contenido) === false) {
            exit(mostrar_error('Informe', "No se puede escribir en el archivo ($archivo)"));
        }
        fclose($gestor);
    }
}
