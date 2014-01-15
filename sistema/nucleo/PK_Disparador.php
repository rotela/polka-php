<?php
namespace sistema\nucleo;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
use \Exception;
/**
 * Clase que supervisa que controlador, método y argumento se está
 * recibiendo, y donde debe dirigirla
 *
 * @author Ricardo Rotela González ricksystems->gmail.com
 * @package sistema
 * @subpackage nucleo
 * @copyright Ricksystems (c)2014
 */
class PK_Disparador
{
	/**
	 * Contenedor para el nombre del controlador
	 * @var string
	 */
	private static $controlador;
	/**
	 * Contenedor para el nombre del método
	 * @var string
	 */
	private static $metodo;
	/**
	 * Contenedor para la ruta del controlador
	 * @var string
	 */
	private static $rutaControlador;
	/**
	 * Contenedor para el nombre de espacio
	 * @var string
	 */
	private static $nombre_spacio;
	/**
	 * Función principal que inicia el sistema,
	 * se solicitará los datos a PK_Solicitud para
	 * saber a que controlador y método delegar lo solicitado
	 * desde el navegador
	 *
	 * ATENCIÓN
	 *
	 * Esta función no devuelve nada, sin embargo ejecuta
	 * el controlador o clase y/o método solicitado desde el navegador
	 */
	public static function iniciar()
	{
		$config            = PK_Config::obt_instancia()->obtener('aplicacion');
		// gancho
		if ($config->gancho) {
			foreach ($config->ganchos as $clase => $metodo) {
				$clase = "aplicacion\gancho\\".$clase;
				seguir('disparando gancho '.$clase);
				$clase = new $clase;
				call_user_func(array($clase,$metodo));
			}
		}
		//
		self::$controlador = PK_Solicitud::obt_controlador();
		self::$controlador = !empty(self::$controlador) ? self::$controlador : $config->ctr_princ;
		self::$metodo      = PK_Solicitud::obt_metodo();
		self::$metodo      = !empty(self::$metodo) ? self::$metodo : $config->mth_princ;
		// se dirige al controlador del usuario o del sistema
		switch (self::$controlador) {
			case 'pkgen':
				self::$rutaControlador = SIS_CONTROLADORES.self::$controlador.'.php';
				self::$nombre_spacio   = "sistema\controladores\\".self::$controlador;
				break;
			default:
				self::$rutaControlador = CONTROLADORES.self::$controlador.'.php';
				self::$nombre_spacio   = "aplicacion\controladores\\".self::$controlador;
				break;
		}
		self::disparar();
	}
	/**
	 * Se dispara el controlador solicitado con su respectivo método y argumentos
	 */
	private static function disparar()
	{
		$rutaControlador = self::$rutaControlador;
		// si existe el controlador
		if (file_exists($rutaControlador))
		{
			// instanciar el controlador, y
			$controlador = self::$nombre_spacio;
			$controlador = new $controlador;
			// si existe el método, ejecutarlo
			if (method_exists($controlador, self::$metodo))
			{
				$argumentos = PK_Solicitud::obt_argumentos();
				if (count($argumentos)>0)
				{
					call_user_func_array(array($controlador,self::$metodo), $argumentos);
				}
				else
				{
					call_user_func(array($controlador,self::$metodo));
				}

				if (count(error_get_last())>0)
				{
					throw new Exception(mostrar_error('php',error_get_last(),'php_error'));
				}
			}
			else
			{
				throw new Exception(mostrar_error('Metodo',"El Método no existe."));
			}
		}
		else
		{
			throw new Exception(mostrar_error('no encontrado :-(','La página <strong>'.self::$controlador.'</strong> no existe '));
		}
	}
}

/* Final de archivo PK_Disparador.php */
/* Ubicación: ./sistema/nucleo/PK_Disparador.php */