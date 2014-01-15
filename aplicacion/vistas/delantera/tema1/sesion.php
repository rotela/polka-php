<?php
eco_ln(obt_alerta('temporal'));
foreach ($datos_sesion as $key => $value) {
	eco_ln($key.': '.$value);
}
?>