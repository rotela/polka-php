<?php
namespace aplicacion\gancho;
if(!defined('NUCLEO')) exit('No se permite acceso directo al script');
class Chequeo
{
	public function principal()
	{
		$admitidos = array(
			'login',
			'login/salir',
			'prueba'
			);
		if (!in_array(url_seg(1), $admitidos))
		{
			if (!obt_coleccion('sistema\librerias\sesion')->obt_datos('cod_usu'))
			{
				redirigir(base_url('login'));
			}
			else
			{
				if (url_seg(1) != '')
				{
					obt_coleccion('aplicacion\librerias\permisos')->check_permisos();
				}
			}
		}
	}
}

/* Final de archivo comprobar.php */
/* Ubicación: gancho/comprobar.php */