<?php
if (!function_exists('fecha')) {
	function fecha()
	{
		return date('Y-m-d');
	}
}
if (!function_exists('hora')) {
	function hora()
	{
		return date('h-i-s');
	}
}
if (!function_exists('fecha_hora')) {
	function fecha_hora()
	{
		return date('Y-m-d h:i:s');
	}
}
if (!function_exists('fecha_a')) {
	function fecha_a($fecha,$formato='d-m-Y')
	{
		return (empty($fecha)) ? '' : date($formato, strtotime($fecha));
	}
}
if(!function_exists('faltan_dias')){
	function faltan_dias($end=null)
	{
		$start = new DateTime();

	    if(!($end instanceof DateTime)) {
	        $end = new DateTime($end);
	    }

	    $interval = $start->diff($end);

	    $m = $interval->d;

	    if($m <= 5){
	    	$datos = "faltan $m días";
	    }else{
	    	$datos=$end;
	    }
	    return $datos;
	}
}
if(!function_exists('minutos_pasaron')){
	function minutos_pasaron($start, $end=null)
	{
		if(!($start instanceof DateTime)) {
	        $start = new DateTime($start);
	    }

	    if($end === null) {
	        $end = new DateTime();
	    }

	    if(!($end instanceof DateTime)) {
	        $end = new DateTime($start);
	    }

	    $interval = $end->diff($start);
	    $datos=$start;
	    $m = $interval->i;
	    if($m <= 59){
	    	$datos = "hace $m minutos";
	    }
	    return $datos;
	}
}
if (!function_exists('fecha_pasaron')) {

	function fecha_pasaron($start, $end=null)
	{
	    if(!($start instanceof DateTime)) {
	        $start = new DateTime($start);
	    }

	    if($end === null) {
	        $end = new DateTime();
	    }

	    if(!($end instanceof DateTime)) {
	        $end = new DateTime($start);
	    }

	    $interval = $end->diff($start);
	    $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals

	    $format = array();
	    if($interval->y !== 0) {
	        $format[] = "%y ".$doPlural($interval->y, "año");
	    }
	    if($interval->m !== 0) {
	        $format[] = "%m ".$doPlural($interval->m, "mes");
	    }
	    if($interval->d !== 0) {
	        $format[] = "%d ".$doPlural($interval->d, "día");
	    }
	    if($interval->h !== 0) {
	        $format[] = "%h ".$doPlural($interval->h, "hora");
	    }
	    if($interval->i !== 0) {
	        $format[] = "%i ".$doPlural($interval->i, "minuto");
	    }
	    if($interval->s !== 0) {
	        if(!count($format)) {
	            return "menos de un minuto";
	        } else {
	            $format[] = "%s ".$doPlural($interval->s, "segundos");
	        }
	    }

	    // We use the two biggest parts
	    if(count($format) > 1) {
	        $format = array_shift($format)." y ".array_shift($format);
	    } else {
	        $format = array_pop($format);
	    }

	    // Prepend 'since ' or whatever you like
	    return $interval->format($format);
	}
}