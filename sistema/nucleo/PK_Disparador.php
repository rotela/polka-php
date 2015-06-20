<?php

namespace sistema\nucleo;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

use sistema\controladores\Errores as Errores;
use \Exception;

/**
 *
 * Clase que supervisa que controlador, método y argumento se está
 * recibiendo, y donde debe dirigirla
 *
 * @author Ricardo Rotela González ricksystems->gmail.com
 * @package sistema
 * @subpackage nucleo
 * @copyright Ricksystems (c)2015
 */
class PK_Disparador {

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

    USE PK_Singleton;

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
    public static function iniciar() {
        $config = PK_Config::obt_instancia()->obtener('aplicacion');
        // OBTENIENDO LA SOLICITUD
        self::$controlador = PK_Solicitud::obt_controlador();
        self::$controlador = !empty(self::$controlador) ? self::$controlador : $config->ctr_princ;
        self::$metodo = PK_Solicitud::obt_metodo();
        self::$metodo = !empty(self::$metodo) ? self::$metodo : $config->mth_princ;
        // Ejecuto la pagina de error si es que existe
        if (self::$controlador == 'errores') {
            $controlador = new Errores();
            $argumentos = PK_Solicitud::obt_argumentos();
            if (count($argumentos) > 0) {
                call_user_func_array(array($controlador, self::$metodo), $argumentos);
            } else {
                call_user_func(array($controlador, self::$metodo));
            }
            exit();
        }
        // EJECUTANDO GANCHO, SI EXISTE.
        if ($config->gancho) {
            foreach ($config->ganchos as $clase => $metodo) {
                $clase = GANCHOS . $clase;
                $clase = str_replace("/", "\\", $clase);
                seguir('disparando gancho ' . $clase);
                $clase = new $clase;
                call_user_func(array($clase, $metodo));
            }
        }
        // EJECUTANDO EL CONTROLADOR
        // Redirigiendo a la subcarpeta, si es que las hay.
        $espacio = str_replace("\\", SD, "aplicacion\controladores\\");
        if (empty(PK_Solicitud::$sub_carpeta)) {
            self::$rutaControlador = CONTROLADORES . self::$controlador . '.php';
            self::$nombre_spacio = $espacio . self::$controlador;
        } else {
            self::$rutaControlador = CONTROLADORES . PK_Solicitud::$sub_carpeta . self::$controlador . '.php';
            self::$nombre_spacio = $espacio . PK_Solicitud::$sub_carpeta . self::$controlador;
        }
        self::disparar();
    }

    /**
     * Se dispara el controlador solicitado con su respectivo método y/o argumentos
     */
    private static function disparar() {
        $rutaControlador = self::$rutaControlador;
        // si existe el controlador
        if (file_exists($rutaControlador)) {
            // instanciar el controlador, y
            global $obj_controlador;
            $controlador = self::$nombre_spacio;
            $controlador = str_replace("/", "\\", $controlador);
            $obj_controlador = new $controlador;
            $controlador = & $obj_controlador;
            // si existe el método, ejecutarlo
            if (method_exists($controlador, self::$metodo)) {
                $argumentos = PK_Solicitud::obt_argumentos();
                if (count($argumentos) > 0) {
                    call_user_func_array(array($controlador, self::$metodo), $argumentos);
                } else {
                    call_user_func(array($controlador, self::$metodo));
                }
                // Obteniendo errores
                if (count(error_get_last()) > 0) {
                    throw new Exception(mostrar_error('php', error_get_last(), 'php_error'));
                }
            } else {
                throw new Exception(mostrar_error('Metodo', "El Método no existe."));
            }
        } else {
            throw new Exception(mostrar_error('no encontrado :-(', 'La página <strong>' . self::$controlador . '</strong> no existe '));
        }
    }

    public static function obt_nombre_spacio() {
        return self::$nombre_spacio;
    }

    public static function obt_obj_controlador() {
        return self::$obj_controlador;
    }

}

/* Final de archivo PK_Disparador.php */
/* Ubicación: ./sistema/nucleo/PK_Disparador.php */