<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
if (!function_exists('pk_titulo')) {
    require 'vista.php';
}
if (!function_exists('mostrar_error')) {

    /**
     * Muestra un mensaje de error.
     *
     * @param string $titulo  Titulo del error
     * @param string $mensaje Mensaje o cuerpo del error
     *
     * @return mixed Salida al navegador
     */
    function mostrar_error($titulo = 'titulo', $mensaje = 'mensaje', $capa = 'error_general')
    {
        $datos = array(
            'titulo' => $titulo,
            'mensaje' => $mensaje,
        );

        if (es_ajax()) {
            echo json_encode($datos);
        } else {
            $url = url_base('sistema/vistas/');
            $css = $url.'css/';
            $js = $url.'js/';
            $error = array(
              'css' => $css,
              'js' => $js,
              'contenido' => ver_error($capa, $datos, false),
          );
            ver_error('index', $error);
        }
    }
}
if (!function_exists('ver_error')) {

    /**
     * Renderiza la plantilla del error con sus contendidos
     * diseñado para uso exclusivo de mostrar_error().
     *
     * @param string $p      Página o vista
     * @param array  $d      Colección de Datos
     * @param bool   $render Se indica si se quiere renderizar
     *                       o retornar sus datos, rederizados como string
     *
     * @return mixed Salida al navegador o retora como datos
     */
    function ver_error($p = '', $d = array(), $render = true)
    {
        extract($d);
        ob_start();
        require 'sistema/vistas/'.agr_ext($p);
        if ($render) {
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
