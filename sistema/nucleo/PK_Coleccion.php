<?php

namespace sistema\nucleo;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

/**
 * Colección principal de librerías/modelos (clases) para el sistema y el usuario,
 * de éste se obtienen calquier clase, si es nueva se creará si no se instanciará
 * de uno ya creado por algún proceso anterior y la devuelve.
 *
 * ADVERTENCIA
 *
 * Para obtener una librerías/modelos (clases) debe indicar su nombre completo de espacio,
 * PHP 5.4 vino con varios soportes tanto para los trait, namespace y los registros
 * de autoloads, utilicémoslo. ;-)
 *
 * USOS
 *
 * Controlador:
 * Se usa en el Controlador principal con la función $this->librerias(), $this->modelos()
 *
 * Librerías y Ayudas:
 * Se usa en las librerías y ayudas nativas
 * Se puede usar en las librerías del usuario con la función obt_instancia(), ejemplo:
 * si quisiera usar la librería sesion en una ayuda o una librería sería así:
 * $sesion = obt_instancia('sistema\librerias\sesion');
 * $sesion->obt_datos();
 *
 * @author  Ricardo Rotela González rotelabs->gmail.com ;-)
 * @copyright Rotelabs (c)2014
 */
class PK_Coleccion
{
    /**
     * Propiedad dónde irá los recursos como clases, librerías, etc.
     *
     * @var array
     */
    private static $librerias = array();

    /*
     * Uso la función Singleton
     */
    use PK_Singleton;

    /**
     * Instancia la librería o modelo y la guarda en la propiedad librerias,
     * devuelve su objeto instanciado.
     *
     * @param string $libreria Nombre del recurso, con su full name
     *
     * @return object El objeto instanciado
     */
    private static function cargar($libreria = '', $param = '')
    {
        if (empty($param)) {
            self::$librerias[$libreria] = new $libreria();
        } else {
            self::$librerias[$libreria] = new $libreria($param);
        }

        return self::$librerias[$libreria];
    }

    /**
     * Obtiene un recurso (clase,librería,modelo) si existe, si no existe,
     * se creará una nueva instancia de la misma y la devolverá como objeto.
     *
     * @param string $libreria Nombre del recurso, cun su full name
     *
     * @return object El objecto instanciado
     */
    public static function obtener($libreria = '', $param = '')
    {
        if (empty($libreria)) {
            mostrar_error('PK_Coleccion', 'Nombre de librería vacía');
        }
        $libreria = self::verificar($libreria);
        if (array_key_exists($libreria, self::$librerias)) {
            seguir('Instanciando '.$libreria);
            return self::$librerias[$libreria];
        } else {
            seguir('Obteniendo '.$libreria);
            if (empty($param)) {
                return self::cargar($libreria);
            } else {
                return self::cargar($libreria, $param);
            }
        }
    }

    /**
     * Obtiene las colecciones de recursos y las devueve como array.
     *
     * @return array Las colecciones de recursos
     */
    public static function obt_coleccion()
    {
        return self::$librerias;
    }

    /**
     * Verifica si el nombre del recurso cumple con ciertos criterios,
     * validaciones que se deben cumplir, además de adaptar el fullname del
     * recurso para compatibilidad de sistemas operativos (linux/windows).
     *
     * @param string $libreria Nombre del recurso
     *
     * @return mixed Devuelve el nombre fullname válido, o un error
     */
    private static function verificar($libreria = '')
    {
        if (strpos($libreria, '\\') === false) {
            mostrar_error('PK_Coleccion', "Debes indicar el espacio de nombre completo de <strong>$libreria</strong>");
        } else {
            $archivo = str_replace('\\', SD, $libreria);
            if (file_exists(agr_ext($archivo))) {
                $archivo = str_replace(SD, '\\', $libreria);

                return $archivo;
            } else {
                mostrar_error('PK_Coleccion', "No existe la librería o modelo <strong>$archivo</strong>");
            }
        }
    }
}

/* Final de archivo PK_Coleccion.php */
/* Ubicación: ./sistema/nucleo/PK_Coleccion.php */
