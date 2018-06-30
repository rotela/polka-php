<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

if (!function_exists('tiempo_inicio')) {
  function tiempo_inicio()
  {
    global $starttime;
    $mtime = microtime();
    $mtime = explode(' ', $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $starttime = $mtime;
  }
}
if (!function_exists('tiempo_fin')) {
  function tiempo_fin()
  {
    global $starttime;
    $mtime = microtime();
    $mtime = explode(' ', $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $trans = ($mtime - $starttime);
    return round($trans, 4);
  }
}
if (!function_exists('memoria_inicio')) {
  function memoria_inicio()
  {
    global $mem_inicio;
    $mem_inicio = memory_get_usage(true);
  }
}

if (!function_exists('memoria_usada_libre')) {
  function memoria_usada_libre()
  {
    global $mem_inicio;
    $mem_fin = memory_get_usage(true);
    $men_total = $mem_fin - $mem_inicio;
    return convertir($men_total);
  }
}
if (!function_exists('memoria_usada')) {
  function memoria_usada()
  {
    $size = memory_get_usage(true);
    $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$unit[$i];
  }
}
if (!function_exists('memoria_usada_b')) {
    function memoria_usada_b()
  {
    $mem_usage = memory_get_usage(true);
    $r = '';
    if ($mem_usage < 1024) {
      $r = $mem_usage.' b';
    } elseif ($mem_usage < 1048576) {
      $r = round($mem_usage / 1024, 2).' kb';
    } else {
      $r = round($mem_usage / 1048576, 2).' mb';
    }

    return $r;
  }
}
