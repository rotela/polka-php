<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
/**
 * Requerimos de php 5.4+
 */
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50400) {
    exit('Polka requiere PHP 5.4 o superior, lo sentimos.');
}

spl_autoload_register('cargar');

/**
 * Función cargar, incluye los archivos que solicita el sistema
 * @param  string $clase Nombre del recurso (clase)
 */
function cargar($clase = '') {
    $clase = str_replace('\\', SD, $clase);
//        echo " se pidio cargar la clase: ".$clase.'.php'."<br>";
    require $clase . '.php';
}

/**
 * Carga las definiciones o variables globales sistema
 */
include NUCLEO . 'PK_Globales.php';
/**
 * Cargando el seguidor de ejecución
 */
include SIS_AYUDAS . 'sis_seguimiento.php';

include SIS_AYUDAS . 'recursos.php';

/**
 * Carga las funciones de manejo de archivo
 */
include SIS_AYUDAS . 'sis_archivos.php';
/**
 * Carga las funciones para obtención de url's
 */
include SIS_AYUDAS . 'urls.php';
/**
 * Carga la función de obtener Colección rápida
 */
include SIS_AYUDAS . 'colectores.php';

/**
 * Carga las funciones de ayuda para manejo de errores del sistema
 */
include SIS_AYUDAS . 'sis_errores.php';
/**
 * Carga las configuraciones principales del sistema
 */
include SIS_CONFIG . 'sis_principal.php';
/**
 * Carga de benchmark, bien podría incluirlo al final para
 * que el tiempo de ejecución muestre menor tiempo, pero eso
 * sería mentir al usuario y peor aún, mentirme a mi mismo.
 */
include SIS_AYUDAS . 'benchmark.php';

/**
 * Activa inicio de tiempo de ejecución.
 * HORA DEL SHOW
 */
tiempo_inicio();
/**
 * Registro la función de autocargas de recursos
 */
