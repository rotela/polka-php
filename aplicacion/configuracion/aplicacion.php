<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
// Url del proyecto
$config['base_url']  = 'http://localhost/tareas';
// Control principal que se dispará al introducir la url,
// anterior indicado
$config['ctr_princ'] = 'bienvenido';
// Método principal que se dispará al invocar el controlador
// anterior indicado
// La configuración mencionada es lo mismo que ingresar en el
// navegador la url: http://localhost/tagua/bienvenido/principal
$config['mth_princ'] = 'principal';
// Clave del candado (es muy recomendable cambiarlo)
$config['clave_can'] = 'tareas';
// Proteccion CSRF
$config['csrf']      = FALSE;
// Nombre interno y de campo para los token (aplicable sólo si lo anterior está en TRUE);
$config['csrf_nom']  = 'joeblack';
// Seguimiento (si se activa puede sobrecargar un poco el tiempo de ejecución)
$config['seguir']    = FALSE;
// Se utiliza gancho
$config['gancho']    = FALSE;
$config['ganchos']   = array();