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
		return date($formato, strtotime($fecha));
	}
}