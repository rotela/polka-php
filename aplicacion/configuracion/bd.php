<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
// Servidor de la base datos
// Si es lento con localhost, probar con la ip (es más rápida)
// eso generalemente se debe a la resolución de nombre entre localhost y la ip
$config['host_bd'] = '127.0.0.1';
// Puerto de la base datos
$config['port_bd'] = 3306;
// Tipo de datos (pgsql, mysql, sqlite)
$config['tipo_bd'] = 'mysql';
// Usuario de la base de datos
$config['user_bd'] = 'root';
// Password de la base de datos
$config['pass_bd'] = '123456';
// Base de datos a utilizar
$config['base_bd'] = 'paypar';
// Cotejamiento de la datos a utilizar
$config['cote_bd'] = 'utf8';
