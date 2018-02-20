<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
function tiempo_inicio()
{
    global $starttime;
    $mtime = microtime();
    $mtime = explode(' ', $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $starttime = $mtime;
}
function tiempo_fin()
{
    global $starttime;
    $mtime = microtime();
    $mtime = explode(' ', $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $trans = ($mtime - $starttime);

    return round($trans, 4);
}

function memoria_inicio()
{
    global $mem_inicio;
    $mem_inicio = memory_get_usage(true);
}
function memoria_usada_libre()
{
    global $mem_inicio;
    $mem_fin = memory_get_usage(true);
    $men_total = $mem_fin - $mem_inicio;

    return $men_total;
}