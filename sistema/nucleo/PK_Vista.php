<?php

namespace sistema\nucleo;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

use \Exception;

/**
 * Clase individual para manejo de vistas,
 * esta clase es usada dentro del controlador
 * y puede ser invocada con la cláusula $this
 * @package sistema
 * @subpackage nucleo
 */
class PK_Vista {

    private $tema = '';
    private $seccion = '';
    private $variables = array();
    public $sis = FALSE;
    private $arch_js = array();

    use PK_Singleton;

    private function __construct() {
        $config = PK_Config::obt_instancia()->obtener('vistas');
        $this->tema = $config->tema;
        $this->seccion = $config->seccion;
        $this->cargar_ayuda();
    }

    public function __set($propiedad = '', $valor = '') {
        if (!in_array($valor, $this->variables)) {
            $this->variables[$propiedad] = $valor;
        }
    }

    public function ver($p, $d = array(), $render = TRUE) {
        if ($this->sis) {
            $pagina = SISTEMA . SD . 'vistas' . SD . agr_ext($p);
        } else {
            $pagina = APLICACION . 'vistas' . SD . $this->seccion . SD . $this->tema . SD . agr_ext($p);
        }

        if (file_exists($pagina)) {
            (empty($d)) ? extract($this->variables) : extract($d);
            ob_start();
            require($pagina);
            if ($render) {
                echo ob_get_clean();
            } else {
                return ob_get_clean();
            }
        } else {
            throw new Exception(mostrar_error('Vista', "La Vista $pagina no existe."));
        }
    }

    public function capa($p, $d = array()) {
        return $this->ver($p, $d, FALSE);
    }

    public function obt_seccion() {
        return $this->seccion;
    }

    public function obt_tema() {
        return $this->tema;
    }

    public function env_seccion($seccion = '') {
        return $this->seccion = $seccion;
    }

    public function env_tema($tema = '') {
        return $this->tema = $tema;
    }

    public function env_arc_js($js='',$pub=false) {
        $aux = 'nohay.js';
        if (is_array($js)) {
            if (count($js) > 0) {
                foreach ($js as $value) {
                    $archivo = agr_ext($value, '.js');
                    $url = vista_js($archivo,$pub);
                    $this->arch_js[] = '<script src="' . $url . '"></script>';
                }
            } else {
                $this->arch_js = $aux;
            }
        } else {
            if (!empty($js)) {
                $archivo = agr_ext($js, '.js');
                $url = vista_js($archivo,$pub);
                $this->arch_js[] = '<script src="' . $url . '"></script>';
            } else {
                $this->arch_js[] = $aux;
            }
        }
    }

    public function obt_arc_js() {
        if (count($this->arch_js) > 0) {
            return implode("\n", $this->arch_js)."\t\n";
        } else {
            return '';
        }
    }

    public function usar_sistema($value = TRUE) {
        $this->sis = $value;
    }

    public function cargar_ayuda() {
        obt_ayuda('vista');
    }

}
