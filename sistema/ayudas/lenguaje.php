<?php
if (!function_exists('traducir')) {
	/**
	 * $num    = 30;
	 * $loc    = 'Villa elisa';
	 * $zoo    = 2;
	 * $format = 'En %2$s hay mas de %1$d monos.
	 * Asi mismo, %1$d monos hay en %2$s monkeys y %3$d zoologicos.';
	 * echo $this->mressf($format, $num, $loc, $zoo);
	 * @return string Texto formateado
	 */
	function traducir()
	{
		$args  = func_get_args();
		if (count($args) < 2) return false;
		$query = array_shift($args);
		$args  = array_map('mysql_real_escape_string', $args);
		array_unshift($args, $query);
		$query = call_user_func_array('sprintf', $args);
	    return $query;
	}
}