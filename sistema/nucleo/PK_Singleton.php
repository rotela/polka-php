<?php

namespace sistema\nucleo;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

/**
 * 
 * @author Ricardo Rotela González :: rotelabs->gmail.com ;-)
 * @copyright Rotelabs (c)2014
 *  
 */
trait PK_Singleton
{
    private static $instancia;

    public static function obt_instancia($parametro = '')
    {
        if (!self::$instancia instanceof self) {
            seguir('Instanciando ' . __CLASS__);
            if (empty($parametro)) {
                self::$instancia = new self();
            } else {
                self::$instancia = new self($parametro);
            }
        }
        return self::$instancia;
    }

    public function __clone()
    {
        exit(mostrar_error('PK_Singleton', 'Clone no se permite en ' . __CLASS__));
    }
}
