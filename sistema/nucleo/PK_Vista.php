<?php

namespace sistema\nucleo;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

use Exception;

/**
 * Clase individual para manejo de vistas,
 * esta clase es usada dentro del controlador
 * y puede ser invocada con la cláusula $this.
 * 
 * @author Ricardo Rotela González :: rotelabs->gmail.com ;-)
 * @copyright Rotelabs (c)2014
 * 
 */
class PK_Vista
{
    private $tema = '';
    private $seccion = '';
    private $variables = array();
    public $sis = false;
    private $arch_js = array();
    private $arch_css = array();

    use PK_Singleton;

    private function __construct()
    {
        $config = PK_Config::obt_instancia()->obtener('vistas');
        $this->tema = $config->tema;
        $this->seccion = $config->seccion;
        $this->cargar_ayuda();
    }

    public function __set($propiedad = '', $valor = '')
    {
        $this->variables[$propiedad] = $valor;
    }

    public function ver($p, $d = array(), $render = true)
    {
        if ($this->sis) {
            $pagina = SISTEMA . SD . 'vistas' . SD . agr_ext($p);
        } else {
            $pagina = VISTAS . $this->seccion . SD . $this->tema . SD . agr_ext($p);
        }

        if (file_exists($pagina)) {
            if (preg_match('/.html$/', $p) == 0) {
                (empty($d)) ? extract($this->variables) : extract($d);
                ob_start();
                require $pagina;
                if ($render) {
                    echo ob_get_clean();
                } else {
                    return ob_get_clean();
                }
            } else {
                require $pagina;
            }
        } else {
            throw new Exception(mostrar_error('Vista', "La Vista $pagina no existe."));
        }
    }

    public function capa($p, $d = array())
    {
        return $this->ver($p, $d, false);
    }

    public function obt_seccion()
    {
        return $this->seccion;
    }

    public function obt_tema()
    {
        return $this->tema;
    }

    public function env_seccion($seccion = '')
    {
        return $this->seccion = $seccion;
    }

    public function env_tema($tema = '')
    {
        return $this->tema = $tema;
    }

    public function env_arc_js($js = '', $pub = false)
    {
        $aux = 'nohay.js';
        if (is_array($js)) {
            if (count($js) > 0) {
                foreach ($js as $value) {
                    $archivo = agr_ext($value, '.js');
                    $url = vista_js($archivo, $pub);
                    $this->arch_js[] = '<script src="' . $url . '"></script>';
                }
            } else {
                $this->arch_js = $aux;
            }
        } else {
            if (!empty($js)) {
                $archivo = agr_ext($js, '.js');
                $url = vista_js($archivo, $pub);
                $this->arch_js[] = '<script src="' . $url . '"></script>';
            } else {
                $this->arch_js[] = $aux;
            }
        }
    }

    public function env_arc_css($css = '', $pub = false)
    {
        $aux = 'nohay.css';
        if (is_array($css)) {
            if (count($css) > 0) {
                foreach ($css as $value) {
                    $archivo = agr_ext($value, '.css');
                    $url = vista_css($archivo, $pub);
                    $this->arch_css[] = '<link href="' . $url . '">';
                }
            } else {
                $this->arch_css = $aux;
            }
        } else {
            if (!empty($css)) {
                $archivo = agr_ext($css, '.css');
                $url = vista_css($archivo, $pub);
                $this->arch_css[] = '<link href="' . $url . '">';
            } else {
                $this->arch_css[] = $aux;
            }
        }
    }

    public function obt_arc_js()
    {
        if (count($this->arch_js) > 0) {
            return implode("\n", $this->arch_js) . "\t\n";
        } else {
            return '';
        }
    }

    public function obt_arc_css()
    {
        if (count($this->arch_css) > 0) {
            return implode("\n", $this->arch_css) . "\t\n";
        } else {
            return '';
        }
    }

    public function usar_sistema($value = true)
    {
        $this->sis = $value;
    }

    public function cargar_ayuda()
    {
        obt_ayuda('vista');
    }
}
