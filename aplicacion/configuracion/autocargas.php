<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
// cargar ayudas
$config['ayudas'] = array('html', 'sesion', 'fecha_hora', 'numeros');
// cargar librerias
$config['librerias'] = array('sesion');
// carga de modelos
$config['modelos'] = array();
