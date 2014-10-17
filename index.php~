<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Asuncion');

define('SD', DIRECTORY_SEPARATOR);
define('RAIZ', realpath(dirname(__FILE__)) . SD);
define('SISTEMA', 'sistema' . SD);
define('NUCLEO', SISTEMA . 'nucleo' . SD);
require NUCLEO . 'PK_Autocargar.php';

try {
    sistema\nucleo\PK_Disparador::iniciar();
} catch (Exception $e) {
    echo $e->getMessage();
}