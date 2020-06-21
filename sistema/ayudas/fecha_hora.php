<?php

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

if (!function_exists('fecha')) {
    function fecha()
    {
        return date('Y-m-d');
    }
}

if (!function_exists('hora')) {
    function hora()
    {
        return date('H-i-s');
    }
}

if (!function_exists('fecha_hora')) {
    function fecha_hora()
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('dma_amd')) {
    function dma_amd($fecha, $formato = 'Y-m-d', $formato_ori = 'd-m-Y')
    {
        return (empty($fecha)) ? '' : date_format(date_create_from_format($formato_ori, $fecha), $formato);
    }
}
if (!function_exists('amd_dma')) {
    function amd_dma($fecha, $formato = 'd-m-Y', $formato_ori = 'Y-m-d')
    {
        return (empty($fecha)) ? '' : date_format(date_create_from_format($formato_ori, $fecha), $formato);
    }
}
if (!function_exists('fecha_a')) {
    function fecha_a($fecha, $formato = 'd-m-Y', $formato_ori = 'Y-m-d')
    {
        return (empty($fecha)) ? '' : date($formato, strtotime($fecha));
    }
}

if (!function_exists('faltan_dias')) {
    function faltan_dias($end = null)
    {
        $start = new DateTime();

        if (!($end instanceof DateTime)) {
            $end = new DateTime($end);
        }

        $interval = $start->diff($end);

        $m = $interval->d;

        if ($m <= 5) {
            $datos = "faltan $m días";
        } else {
            $datos = $end;
        }

        return $datos;
    }
}
if (!function_exists('minutos_pasaron')) {
    function minutos_pasaron($start, $end = null)
    {
        if (!($start instanceof DateTime)) {
            $start = new DateTime($start);
        }

        if ($end === null) {
            $end = new DateTime();
        }

        if (!($end instanceof DateTime)) {
            $end = new DateTime($start);
        }

        $interval = $end->diff($start);
        $datos = $start;
        $m = $interval->i;
        if ($m <= 59) {
            $datos = "hace $m minutos";
        }

        return $datos;
    }
}

if (!function_exists('fecha_pasaron')) {
    function fecha_pasaron($start, $end = null, $corto = false)
    {
        if (!($start instanceof DateTime)) {
            $start = new DateTime($start);
        }

        if ($end === null) {
            $end = new DateTime();
        }

        if (!($end instanceof DateTime)) {
            $end = new DateTime($end);
        }

        $interval = $end->diff($start);
        $doPlural = function ($nb, $str) {
            return $nb > 1 ? $str . 's' : $str;
        };

        $format = array();
        if ($interval->y !== 0) {
            $format[] = '%y ' . $doPlural($interval->y, 'año');
        }
        if ($interval->m !== 0) {
            $format[] = '%m ' . $doPlural($interval->m, 'mes');
        }
        if ($interval->d !== 0) {
            $format[] = '%d ' . $doPlural($interval->d, 'día');
        }
        if ($interval->h !== 0) {
            $format[] = '%h ' . $doPlural($interval->h, 'hora');
        }
        if ($interval->i !== 0) {
            $format[] = '%i ' . $doPlural($interval->i, 'minuto');
        }
        if ($interval->s !== 0) {
            if (!count($format)) {
                return ($corto) ? '-1 min' : 'menos de un minuto';
            } else {
                $format[] = '%s ' . $doPlural($interval->s, 'segundo');
            }
        }
        // We use the two biggest parts
        if (count($format) > 1) {
            $format = array_shift($format) . ' y ' . array_shift($format);
        } else {
            $format = array_pop($format);
        }
        // reemplazo cuado es corto

        $orgi = $interval->format($format);
        if ($corto) {
            $a = array('segundo', 'minuto', 'hora', 'dia', 'semana', 'mes', 'año', 'decada');
            $d = array('s', 'm', 'h', 'd', 's', 'mes', 'año', 'dec');
            $orgi = str_replace($a, $d, $orgi);
        }
        // Prepend 'since ' or whatever you like
        return $orgi;
    }
}
if (!function_exists('cant_dias')) {
    function cant_dias($start, $end)
    {
        $diff = date_diff(date_create($start), date_create($end), true);
        $dias = $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h / 24 + $diff->i / 60;
        return $dias;
    }
}
if (!function_exists('fecha_hace')) {
    function fecha_hace($tm, $rcs = 0)
    {
        $tm = strtotime($tm);

        $cur_tm = time();

        $dif = $cur_tm - $tm;
        $pds = array('segundo', 'minuto', 'hora', 'dia', 'semana', 'mes', 'año', 'decada');
        $lngh = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
        for ($v = sizeof($lngh) - 1; ($v >= 0) && (($no = $dif / $lngh[$v]) <= 1); $v--);
        if ($v < 0) {
            $v = 0;
        }
        $_tm = $cur_tm - ($dif % $lngh[$v]);

        $no = floor($no);
        if ($no != 1) {
            $pds[$v] .= 's';
        }
        $x = sprintf("%d %s", $no, $pds[$v]);
        if (($rcs == 1) && ($v >= 1) && (($cur_tm - $_tm) > 0)) {
            $x .= fecha_hace($_tm);
        }
        return $x;
    }
}
if (!function_exists('dif_hms')) {
    function dif_hms($fecha1, $fecha2, $alcance = 6)
    {
        $fechainicial = new DateTime($fecha1);
        //fecha inicial
        $fechaactual = new DateTime($fecha2);
        //fecha de cierre
        $diferencia = $fechainicial->diff($fechaactual);
        //
        $a = $diferencia->format('%Y');
        $b = $diferencia->format('%m');
        $c = $diferencia->format('%d');
        $d = $diferencia->format('%H');
        $e = $diferencia->format('%i');
        $f = $diferencia->format('%s');

        $f = (strlen($f) == 1) ? "0$f" : $f;
        $e = (strlen($e) == 1) ? "0$e" : $e;

        $fechas = array($a, $b, $c, $d, $e, $f);
        $i = 6;
        $r = '';
        foreach ($fechas as $f) {
            if ($i <= $alcance) {
                $r .= (empty($r)) ? "$f" : ":$f";
            }
            $i--;
        }

        return $r;
    }
}
