<?php
if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
/*
 * Requerimos de php 7+
 */
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 70000) {
    exit('Polka PHP requiere PHP 7+ o superior, lo sentimos, actual: ' . PHP_VERSION_ID);
}

spl_autoload_register('pk_cargar');

/**
 * Función cargar, incluye los archivos que solicita el sistema.
 *
 * @param string $clase Nombre del recurso (clase)
 */
function pk_cargar($clase = '')
{
    $clase = str_replace('\\', SD, $clase);
    require $clase . '.php';
}

/**
 * Carga las definiciones o variables globales sistema.
 */
include NUCLEO . 'PK_Globales.php';
/**
 * Cargando el seguidor de ejecución.
 */
include SIS_AYUDAS . 'sis_seguimiento.php';

include SIS_AYUDAS . 'recursos.php';

/**
 * Carga las funciones de manejo de archivo.
 */
include SIS_AYUDAS . 'sis_archivos.php';
/**
 * Carga las funciones para obtención de url's.
 */
include SIS_AYUDAS . 'urls.php';
/**
 * Carga la función de obtener Colección rápida.
 */
include SIS_AYUDAS . 'colectores.php';
/**
 * Carga las funciones de ayuda para manejo de errores del sistema.
 */
include SIS_AYUDAS . 'sis_errores.php';
/**
 * Carga las configuraciones principales del sistema.
 */
include SIS_CONFIG . 'sis_principal.php';
/**
 * Carga de benchmark, bien podría incluirlo al final para
 * que el tiempo de ejecución muestre menor tiempo, pero eso
 * sería mentir al usuario y peor aún, mentirme a mi mismo.
 */
include SIS_AYUDAS . 'benchmark.php';
/*
 * Activa inicio de tiempo de ejecución y memoria inicial.
 * HORA DEL SHOW
 */
memoria_inicio();
tiempo_inicio();
