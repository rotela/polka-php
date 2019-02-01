<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
// Estas configuraciones devuelven/escriben informaciones en el archivo aplicacion/seguimiento/informe.txt

// Devolver error sql nativo
$config['mostrar_error'] = true;
// Devolver el/las sentencias/ordenes sql que se haya/n utilizado por el modelo
$config['informar_sql'] = false;

// Final del archivo aplicacion/configuracion/modelo.php
