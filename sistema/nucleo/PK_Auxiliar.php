<?php

namespace sistema\nucleo;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

/**
 * Clase auxiliar para carga de recursos (librerías, modelos, ayudas)
 * para el núcleo del controlador, ésta clase es de uso excluivo de
 * PK_Controlador.
 *
 * Ejemplo:
 *
 * En un controlador puedes cargar librerías, modelos o ayudas de esta forma:
 *
 * - $this->cargar->librerias('sesion');
 * - $this->cargar->modelos('mod_usuarios');
 * - $this->cargar->ayudas('html');
 *
 * Atención:
 *
 * Esta clase u manera de cargar recursos, no se aplica en los constructures de
 * los controladores. Para cargar recursos en el constructor de un controlador,
 * utilice directo el cargador $this->librerias();
 *
 * Ejemplo:
 *
 * - $this->librerias('sesion');
 * - $this->modelos('mod_usuarios');
 * - $this->ayudas('html');
 *
 *
 * @author Ricardo Rotela González :: ricksystems->gmail.com ;-)
 * @copyright Ricksystems (c)2014
 */
class PK_Auxiliar
{
    public function librerias($nombre_libreria = '', $alias = '', $param = '')
    {
        obt_instancia()->agregar_componente('librerias', $nombre_libreria, $alias, $param);
    }

    public function modelos($nombre_modelos = '', $alias = '', $param = '')
    {
        obt_instancia()->agregar_componente('modelos', $nombre_modelos, $alias, $param);
    }

    public function ayudas($nombre_ayudas = '')
    {
        obt_instancia()->agregar_componente('ayudas', $nombre_ayudas);
    }
}
