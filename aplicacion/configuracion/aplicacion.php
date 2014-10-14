<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
// Url del proyecto
$config['url_base'] = 'http://localhost/polka-php';
// Controlador principal que se dispará al introducir la url,
// anterior indicado
$config['ctr_princ'] = 'bienvenido';
// Método principal que se dispará al invocar el controlador
// anterior indicado
// La configuración mencionada es lo mismo que ingresar en el
// navegador la url: http://localhost/paypar/bienvenido/principal
$config['mth_princ'] = 'principal';
// Duración de sesion en segundos (1800/30m, 3600/1h, 7200/2h)
$config['ses_tiempo'] = 7200;
// Nombre de la aplicación
$config['ap_titulo'] = 'Polka';
// Derechos Reservados de la aplicación
$config['ap_derechos'] = 'Polka Copyright ' . date('Y') . '©';
// Versión la aplicación
$config['ap_version'] = '1.0';
// Clave del candado (es muy recomendable cambiarlo)
$config['clave_can'] = 'polka';
// Proteccion CSRF
$config['csrf'] = FALSE;
// Nombre interno y de campo para los token (aplicable sólo si lo anterior está en TRUE);
$config['csrf_nom'] = 'token';
// Seguimiento (si se activa puede sobrecargar un poco el tiempo de ejecución)
$config['seguir'] = true;
// Se utiliza gancho
$config['gancho'] = false;
// De utlizar gancho, indicar cual es la clase y el método a disparar o ejecutarse
// Los ganchos van en la carpeta Ganchos
$config['ganchos'] = array('comprobar' => 'principal');
