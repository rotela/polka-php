<?php

namespace sistema\nucleo;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

/**
 * Colección principal de Configuraciones para el sistema y el usuario,
 * de éste se obtienen calquier configuración, si es nueva se cargará
 * si no, dovolverá lo que ya se ha cargado por algún proceso anterior.
 *
 * Las configuraciones son archivos .php donde contienen un array con el nombre
 * config, el cual tendrá las configuraciones, La idea es cargar ese archivo
 * y acceder a los datos del array config, con la forma de objetos->propiedades.
 *
 * USOS
 *
 * Controlador:
 * Se usa en el Controlador principal con la función $this->configuracion()
 *
 * Librerías y Ayudas:
 * Se usa en las librerías y ayudas nativas
 * Se puede usar en las librerías del usuario
 *
 * @author Ricardo Rotela González :: rotelabs->gmail.com ;-)
 * @copyright Rotelabs (c)2014
 * 
 */
class PK_Config
{
    /**
     * Colección de configuraciones.
     *
     * @var array
     */
    private static $config = array();

    /*
     * Uso Singleton para las instancias
     */
    use PK_Singleton;

    /**
     * Por el momento no hay nada en el constructor.
     */
    private function __construct()
    {
    }

    /**
     * Función principal para obtener las configuraciones
     * que se haya solicitado.
     *
     * @param string $configuracion Nombre del archivo de configuración
     *
     * @return object Objeto de la configuración
     */
    public static function obtener($configuracion = '')
    {
        // si no esta vacío el parámetro,
        if (!empty($configuracion)) {
            // incluír la configuración
            return self::incluir_configuracion($configuracion);
        } else {
            // si está vacio el parámetro de configuración, mostrar el error
            exit(mostrar_error('PK_Config', 'Parámetro nombre de configuración requerido.'));
        }
    }

    /**
     * Carga la configuración indicada.
     *
     * @param string $configuracion nombre de la configuración a cargar
     *
     * @return object Retorna en la propiedad
     *                config los itenes de la/s confugración/es solicitadas
     */
    private static function incluir_configuracion($configuracion = '')
    {
        // si no existe aún la configuracion
        if (!array_key_exists($configuracion, self::$config)) {
            $carpeta = CONFIGURACION;
            $archivo = $carpeta . agr_ext($configuracion);
            // si existe la configuracion en la carpeta del usuario,
            if (file_exists($archivo)) {
                // incluirla, o,
                return self::anidar_configuracion($archivo);
            } else {
                // si no existe en la configuración del usuario, buscar en el sistema,
                $carpeta = SIS_CONFIG;
                $archivo = $carpeta . agr_ext($configuracion);
                // si existe en el sitema,
                if (file_exists($archivo)) {
                    // incluirla, o,
                    return self::anidar_configuracion($archivo);
                } else {
                    // enviar el error al navegador.-
                    exit(mostrar_error(__CLASS__, 'No existe el archivo de configuracion ' . $archivo));
                }
            }
        } else {
            return self::$config[$configuracion];
        }
    }

    /**
     * Se incluye el archivo de configuración y se lo convierte
     * en objeto para la colección de configuraciones y se devuelve
     * el objeto de este último.
     *
     * @param string $archivo Nombre del archivo de configuración
     *
     * @return object Objeto de la configuración
     */
    private static function anidar_configuracion($archivo = '')
    {
        seguir('Registrando configuracion ' . $archivo);
        // incluír el archivo
        include $archivo;
        // si no existe la variable $config, mostrar error
        if (!isset($config)) {
            exit(mostrar_error('PK_Config', 'No se ha creado el arreglo $config dentro de: ' . $archivo . ',<br>
				Cree un arreglo vacío por lo menos.'));
        }
        // preparo para crear un objeto de la configuración incluída
        $clave = nom_arc_sim($archivo);
        self::$config[$clave] = new \ArrayObject($config, \ArrayObject::ARRAY_AS_PROPS);
        unset($config);

        return self::$config[$clave];
    }

    /**
     * Devuelve la colección de configuraciones en un array.
     *
     * @return [type] [description]
     */
    public static function obt_configuraciones()
    {
        return self::$config;
    }
}

/* Final de archivo PK_Config.php */
/* Ubicación: ./sistema/nucleo/PK_Config.php */
