<?php

namespace aplicacion\controladores;

(!defined('APLICACION')) ? exit('No se permite el acceso directo al script.') : false;

use sistema\nucleo\PK_Controlador as PK_Controlador;

class bienvenido extends PK_Controlador
{
    public function __construct()
    {
        parent::__construct();
    }

    public function principal()
    {
        /* envío una vista al navegador */
        $this->vista->ver('index');
    }

    public function otro()
    {
        obt_ayuda('xml_json');

        $nombres = array(
            'Homero',
            'Barth',
            'Lisa',
            'Marge',
            'Magie',
        );

        obt_json($nombres);
        // obt_xml(array('nombres'=>$nombres));
    }
}
