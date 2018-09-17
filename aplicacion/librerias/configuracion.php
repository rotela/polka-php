<?php

namespace aplicacion\librerias;

use aplicacion\modelos\mod_configuracion;

/**
 * configuración
 */
class configuracion
{
    public function __construct()
    {
    }

    public static function obt($nombre='')
    {
        $valor = $nombre;

        $mod = new mod_configuracion();
        $result = $mod->buscar_por(array('con_nombre'=>$nombre));
        if ($result) {
            $valor = (!empty($result->con_valor)) ? $result->con_valor : $result['con_valor_fijo'];
        }

        return $valor;
    }
}
