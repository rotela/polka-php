<?php
/* defino algunos parámetros de php */
ini_set('display_errors', 1);
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '20M');
ini_set('max_input_time', 800);
ini_set('max_execution_time', 800);

/* defino zona horaria*/
date_default_timezone_set('America/Asuncion');

/* defino directorios*/
define('SD', DIRECTORY_SEPARATOR);
define('RAIZ', realpath(dirname(__FILE__)) . SD);
define('SISTEMA', 'sistema' . SD);
define('NUCLEO', SISTEMA . 'nucleo' . SD);

/* incluyo la clase de autocargas*/
require NUCLEO . 'PK_Autocargar.php';

/* intento inicializar el sistema, de lo contrario muestro un mensaje*/
try {
    sistema\nucleo\PK_Disparador::iniciar();
} catch (Exception $e) {
    echo $e->getMessage();
}
