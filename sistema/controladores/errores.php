<?php

namespace sistema\controladores;

if (!defined('SISTEMA')) {
    exit('No se permite acceso directo al script');
}

use sistema\nucleo\PK_Controlador;

class Errores extends PK_Controlador
{
    public function __construct()
    {
        parent::__construct();
    }

    public function principal()
    {
        mostrar_error('no encontrada :(', 'La página solicitada no existe');
    }

    public function pagina($value = '')
    {
        switch ($value) {
            case '404':
                mostrar_error('404, no encontrada :(', 'La página solicitada no existe');
                break;
            case '403':
                mostrar_error('403, sin permiso :(', 'Lo sentimos, ésta sección es privada');
                break;
            case '500':
                mostrar_error('500 servidor malo :(', 'El servidor no ha respondido, se ha quedado sin premio');
                break;
            default:
                mostrar_error('no encontrada :(', 'La página solicitada no existe');
                break;
        }
    }

}

/* Final de archivo errores.php */
/* Ubicación: ./sistema/controladores/errores.php */
