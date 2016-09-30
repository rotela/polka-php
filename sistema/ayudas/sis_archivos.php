<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('nombre_archivo')) {

    /**
     * Devuelve la ubicación del archivo indicado.
     *
     * @param string $archivo Nombre del archivo
     *
     * @return string Ubicación del archivo
     */
    function nombre_archivo($archivo = '')
    {
        return basename($archivo);
    }
}
if (!function_exists('nom_arc_sim')) {

    /**
     * Devuelve el nombre de archivo, desde una
     * cadena de carpetas y archivo, en tal caso devolverá
     * sólo el nombre de archivo.
     *
     * @param string $archivo Ubicación y nombre del archivo
     *
     * @return string Nombre del archivo
     */
    function nom_arc_sim($archivo = '')
    {
        $fragmentos = explode('.', basename($archivo));

        return $fragmentos[0];
    }
}
if (!function_exists('agr_ext')) {

    /**
     * Agrega una extensión al nombre del archivo.
     *
     * @param string $archivo Nombre del arhichivo
     * @param string $ext     Extensión a agregar (opcional)
     *
     * @return string Nombre del archivo con la extensión indicada
     */
    function agr_ext($archivo = '', $ext = '.php')
    {
        $patrón = '/.htm|.html|.php$/';
        if (preg_match($patrón, $archivo) == 1) {
            return $archivo;
        } else {
            return $archivo.$ext;
        }
    }
}
if (!function_exists('agr_barra')) {

    /**
     * Agrega una barra al final del nombre del archivo.
     *
     * @param string $archivo Nombre del arhichivo
     * @param string $barra   Barra a agregar (opcional)
     *
     * @return string Nombre del archivo con la barra al final
     */
    function add_barra($archivo = '', $barra = SD)
    {
        $mystring = $archivo;
        $findme = $barra;
        $pos = strpos($mystring, $findme);
        if ($pos === false) {
            return $archivo.$findme;
        } else {
            return $archivo;
        }
    }
}
if (!function_exists('obt_archivos')) {

    /**
     * Lee todos los nombre de archivos y las devuelve.
     *
     * @param string $dir La ruta del directorio
     * @param bool   $ext Agrega o quita (true/false) las extensiones de los archivos
     *
     * @return mixed Arreglo de los nombres de archivos o false si no
     *               existe el directorio especificado
     */
    function obt_archivos($dir = '', $ext = true)
    {
        $dir = str_replace('/', SD, $dir);
        if (is_dir($dir)) {
            $archivos = array();
            if ($gestor = opendir($dir)) {
                while (false !== ($entrada = readdir($gestor))) {
                    if ($entrada != '.' && $entrada != '..') {
                        if ($ext) {
                            $archivos[] = $entrada;
                        } else {
                            $archivos[] = nom_arc_sim($entrada);
                        }
                    }
                }
                closedir($gestor);
            }

            return $archivos;
        } else {
            return false;
        }
    }
}
if (!function_exists('obt_directorios')) {

    /**
     * Lee todos los nombre de archivos y las devuelve.
     *
     * @param string $dir La ruta del directorio
     * @param bool   $ext Agrega o quita (true/false) las extensiones de los archivos
     *
     * @return mixed Arreglo de los nombres de archivos o false si no
     *               existe el directorio especificado
     */
    function obt_directorios($dir = '')
    {
        $dir = str_replace('/', SD, $dir);
        if (is_dir($dir)) {
            $archivos = array();
            if ($gestor = opendir($dir)) {
                while (false !== ($entrada = readdir($gestor))) {
                    $subject = '/[.]/';

                    if ($entrada != '.' && $entrada != '..' && !preg_match($subject, $entrada)) {
                        $archivos[] = $entrada;
                    }
                }
                closedir($gestor);
            }

            return $archivos;
        } else {
            return false;
        }
    }
}

function explorador($dir = '', $res = array())
{
    $dir = str_replace('/', SD, $dir);

    $archivos = $res;

    if (is_dir($dir)) {
        if ($gestor = opendir($dir)) {
            while (false !== ($entrada = readdir($gestor))) {
                if ($entrada != '.' && $entrada != '..') {
                    $item = $dir.'/'.$entrada;
                    $archivos[] = $item;
                    if (is_dir($item)) {
                        explorador($item, $archivos);
                    }
                    eco_ln($item);
                }
            }
            closedir($gestor);
        }
    }
    eco_ln('-> can archivos '.count($archivos));

    return $archivos;
}
