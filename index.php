<?php

/*defino tipo reporte de errores*/
ini_set('display_errors', 1);
error_reporting(E_ALL);

/*defino zona horaria*/
date_default_timezone_set('America/Asuncion');

/*defino directorios*/
define('SD', DIRECTORY_SEPARATOR);
define('RAIZ', realpath(dirname(__FILE__)) . SD);
define('SISTEMA', 'sistema' . SD);
define('NUCLEO', SISTEMA . 'nucleo' . SD);

/*incluyo la clase de autocargas*/
require NUCLEO . 'PK_Autocargar.php';

/*intento inicializar el sistema, de lo contrario muestro un mensaje*/
try {
    sistema\nucleo\PK_Disparador::iniciar();
} catch (Exception $e) {
    echo $e->getMessage();
}
