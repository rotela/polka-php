<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
function tiempo_inicio() {
	global $starttime;
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;
}
function tiempo_fin() {
	global $starttime;
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$trans = ($mtime - $starttime);
	return round($trans,4);
}
function memoria_usada()
{
	return round((memory_get_usage()/1048576),4);
}