<?php
namespace sistema\nucleo;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

/**
 * Clase que supervisa las rutas, ésta procesará y hará las comprobaciones
 * sobre las rutas indicadas en la configuración Rutas.
 *
 * @author Ricardo Rotela González ricksystems->gmail.com
 * @package sistema
 * @subpackage nucleo
 * @copyright Ricksystems (c)2014
 */
class PK_Rutas {

    private $url_origen = '';
    private $url_destino = '';
    private $rutas = '';
    private $hay = false;

    use PK_Singleton;

    function __construct() {
        $this->rutas = PK_Config::obt_instancia()->obtener('rutas');
        if (count($this->rutas) > 0) {
            // Buscamos cohincidencias entre rutas y la url actual
            foreach ($this->rutas as $key => $value) {
                //echo "$key -> $value<br>";
                if ($this->subtraer($key, $value)) {
                    $this->hay = true;
                    break;
                }
            }
        }
    }

    private function subtraer($origen = '', $destino = '') {
        $array_origen  = explode('/', $origen);
        $array_destino = explode('/', $destino);
        $arg           = array();

        foreach ($array_origen as $llave => $valor) {
            if ($valor == '?') {
                $array_origen[$llave] = url_seg($llave + 1);
                $arg[$llave] = url_seg($llave + 1);
            }
        }

        foreach ($array_destino as $llave => $valor) {
            if ($valor == '?') {
                $array_destino[$llave] = array_shift($arg);
            }
        }

        $this->url_origen  = implode('/', $array_origen);
        $this->url_destino = implode('/', $array_destino);
/*
        echo $this->url_origen ."<br>". url_solicitud()."<br>";
        exit();
        */
        return ($this->url_origen == url_solicitud()) ? true : false;
    }

    public function obt_controlador() {
        $cadena = $this->url_destino;
        $buscar = "/";
        $resultado = strpos($cadena, $buscar);
        if ($resultado !== FALSE) {
            $url_array = explode('/', $cadena);
            return $url_array[0];
        } else {
            return $cadena;
        }
    }

    public function obt_metodo() {
        $cadena = $this->url_destino;
        $buscar = "/";
        $resultado = strpos($cadena, $buscar);
        if ($resultado !== FALSE) {
            $url_array = explode('/', $cadena);
            return $url_array[1];
        } else {
            return '';
        }
    }

    public function hay() {
        return $this->hay;
    }

    public function url_destino() {
        return $this->url_destino;
    }

    public function url_origen() {
        return $this->url_origen;
    }

}
