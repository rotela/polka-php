<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
if (!function_exists('alerta_success')) {
	function alerta_success($mensaje='')
	{
		$ale  = '<div class="alert alert-success alert-dismissable">'."\n";
		$ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
		$ale .= $mensaje."\n";
		$ale .='</div>'."\n";
		return $ale;
	}
}
if (!function_exists('alerta_warning')) {
	function alerta_warning($mensaje='')
	{
		$ale  = '<div class="alert alert-warning alert-dismissable">'."\n";
		$ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
		$ale .= $mensaje."\n";
		$ale .='</div>'."\n";
		return $ale;
	}
}

if (!function_exists('alerta_danger')) {
	function alerta_danger($mensaje='')
	{
		$ale  = '<div class="alert alert-danger alert-dismissable">'."\n";
		$ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
		$ale .= $mensaje."\n";
		$ale .='</div>'."\n";
		return $ale;
	}
}

if (!function_exists('alerta_info')) {
	function alerta_info($mensaje='')
	{
		$ale  = '<div class="alert alert-info alert-dismissable">'."\n";
		$ale .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n";
		$ale .= $mensaje."\n";
		$ale .='</div>'."\n";
		return $ale;
	}
}