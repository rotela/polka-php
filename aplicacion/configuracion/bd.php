<?php

(!defined('APLICACION')) ? exit('No se permite el acceso directo al script.') : false;

// Servidor de la base datos
$config['host'] = '127.0.0.1';
// Puerto de la base datos
$config['port'] = 3306;
// Tipo de datos (pgsql, mysql, sqlite)
$config['tipo'] = 'mysql';
// Usuario de la base de datos
$config['user'] = 'root';
// Password de la base de datos
$config['pass'] = '1234';
// Base de datos a utilizar
$config['base'] = 'tubd';
// Cotejamiento de la datos a utilizar
$config['cote'] = 'utf8';
// Cotejamiento de la datos a utilizar
$config['sufi'] = 'app_';
