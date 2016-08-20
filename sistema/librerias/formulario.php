<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

use sistema\nucleo\PK_Controlador;
/*
 Formas de utilización:

 $this->formulario->regla('nombres','Nombre/s','requerido|texto');
 $this->formulario->regla('apellidos','Apellido/s','requerido|texto');
 $this->formulario->regla('documento','Cedula o RUC','requerido|texto');
 $this->formulario->regla('celular','Celular','requerido');
 $this->formulario->regla('email','Email','requerido|validar_email|email');
 $this->formulario->regla('direccion','Dirección','requerido|texto');
 $this->formulario->regla('contrasena','Password','requerido|texto');
 $this->formulario->regla('recontrasena','Repetir Password','requerido|espejo[contrasena]|texto');
 */
class formulario {

    private $pasa;
    private $entradas;
    private $alias;
    public $error;

    function __construct() {
        $this->pasa     = true;
        $this->error    = array();
        $this->alias    = array();
        $this->entradas = $_POST;
        $this->comprobar_token();
        if (!defined('obt_error'))
            PK_Controlador::obt_instancia()->ayudas('formulario');
    }

    public function __get($propiedad) {

        return (array_key_exists($propiedad, $this->entradas)) ? $this->entradas[$propiedad] : '';

    }

    private function comprobar_token() {
        $pk       = obt_config('aplicacion');
        $csrf_nom = $pk->csrf_nom;
        if ($pk->csrf) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (count($_POST) > 0) {
                    if (!isset($_POST[$csrf_nom])) {
                        $this->agr_error($csrf_nom, 'Petición corrupta, no existe el campo token ');
                    }
                    if ($_POST[$csrf_nom] !== $_SESSION[$csrf_nom]) {
                        $this->agr_error($csrf_nom, 'Petición corrupta, los token de sesion y campo no cohinciden');
                    }
                }
            } else {
                $this->env_csrf();
            }
        } else {
            $this->borrar_csrf();
        }
    }

    public function pasa() {
        return (count($_POST) == 0) ? false : $this->pasa;
    }

    public function error($clave = '') {
        if (count($_POST) > 0) {
            if (!empty($clave)) {
                if (array_key_exists($clave, $this->error)) {
                    return $this->error[$clave];
                } else {
                    return "";
                }
            } else {
                return "";
            }
        }
    }

    public function errores() {
        $errores = array();
        if (count($_POST) > 0) {
            foreach ($this->error as $key => $value) {
                if (!empty($value))
                    $errores[$key] = $value;
            }
            return (count($errores) == 0) ? false : $errores;
        }else {
            return false;
        }
    }

    public function regla($campo = '', $alias = '', $reglas = '', $funcion = false) {
        if (count($_POST) > 0) {
            $reglas = explode('|', $reglas);
            foreach ($reglas as $value) {
                if (preg_match('/\[(.*?)\]/', $value, $coincidencias)) {
                    $reglas = explode('[', $value);
                    $regla = $reglas[0];
                    $parametros = array($campo, $alias, $coincidencias[1]);
                } else {
                    $regla = $value;
                    $parametros = array($campo, $alias);
                }
                if (method_exists($this, $regla)) {
                    call_user_func_array(array($this, $regla), $parametros);
                } else {
                    eco_ln("No existe el metodo $regla");
                }
            }
            if ($funcion) {
                $error = call_user_func($funcion);
                if (!empty($error)) {
                    $this->agr_error($campo, $error);
                }
            }
        }
    }

    private function requerido($campo = '', $alias = '') {
        $alias = empty($alias) ? $campo : $alias;
        $this->alias[$campo] = $alias;
        if (array_key_exists($campo, $this->entradas)) {
            if (empty($_POST[$campo])) {
                $this->agr_error($campo, "El campo $alias es requerido");
            }
        } else {
            $this->agr_error($campo, "No existe el campo $alias");
        }
    }

    private function validar_email($campo = '', $alias = '') {
        $alias = empty($alias) ? $campo : $alias;
        if (array_key_exists($campo, $this->entradas)) {
            $email = $_POST[$campo];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->agr_error($campo, "La dirección de correo $email no es válida");
            }
        } else {
            $this->agr_error($campo, '');
        }
    }

    private function validar_entero($campo = '', $alias = '') {
        $alias = empty($alias) ? $campo : $alias;
        if (array_key_exists($campo, $this->entradas)) {
            $valor = $_POST[$campo];
            if (!filter_var($valor, FILTER_VALIDATE_INT)) {
                $this->agr_error($campo, "El campo $alias debe ser de tipo entero (numérico)");
            }
        } else {
            $this->agr_error($campo, '');
        }
    }

    private function validar_ip($campo = '', $alias = '') {
        $alias = empty($alias) ? $campo : $alias;
        if (array_key_exists($campo, $this->entradas)) {
            $ip = $_POST[$campo];
            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                $this->agr_error($campo, "La dirección de ip $ip no es válida");
            }
        } else {
            $this->agr_error($campo, "No existe el campo $alias");
        }
    }

    private function texto_min($campo = '', $alias = '', $cant = 0) {
        $alias = empty($alias) ? $campo : $alias;
        if (array_key_exists($campo, $this->entradas)) {
            $texto = $_POST[$campo];
            if (strlen($texto) < $cant) {
                $this->agr_error($campo, "El campo $alias debe tener por lo menos $cant caracteres");
            }
        } else {
            $this->agr_error($campo, "No existe el campo $alias");
        }
    }

    private function texto_max($campo = '', $alias = '', $max = 0) {
        $alias = empty($alias) ? $campo : $alias;
        if (array_key_exists($campo, $this->entradas)) {
            $texto = $_POST[$campo];
            if (strlen($texto) > $max) {
                $this->agr_error($campo, "El campo $alias no debe exceder $max caracteres");
            }
        } else {
            $this->agr_error($campo, "No existe el campo $alias");
        }
    }

    private function espejo($campo = '', $alias = '', $esp = '') {
        $alias = empty($alias) ? $campo : $alias;
        if (array_key_exists($campo, $this->entradas)) {
            $texto = $_POST[$campo];
            $espej = $_POST[$esp];
            if ($texto !== $espej) {
                $this->agr_error($campo, "El campo $alias debe ser igual al campo " . $this->obt_alias($esp));
            }
        } else {
            $this->agr_error($campo, "No existe el campo $alias");
        }
    }

    public function agr_error($clave = '', $error = '') {
        $this->pasa = false;
        if (array_key_exists($clave, $this->error)) {

            if (empty($this->error[$clave])) {
                $this->error[$clave] = $error;
            }

        } else {
            $this->error[$clave] = $error;
        }
    }

    public function texto($campo = '') {
        if (isset($this->entradas[$campo])) {
            $this->entradas[$campo] = filter_var($this->entradas[$campo], FILTER_SANITIZE_STRING);
        } else {
            $this->agr_error($campo, 'No existe el campo ' . $campo);
        }
    }

    public function email($campo = '') {
        if (isset($this->entradas[$campo])) {
            $this->entradas[$campo] = filter_var($this->entradas[$campo], FILTER_SANITIZE_EMAIL);
        } else {
            $this->agr_error($campo, 'No existe el campo ' . $campo);
        }
    }

    public function entero($campo = '') {
        if (isset($this->entradas[$campo])) {
            $this->entradas[$campo] = filter_var($this->entradas[$campo], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $this->agr_error($campo, 'No existe el campo ' . $campo);
        }
    }

    public function url_amigable($campo = '') {
        if (isset($this->entradas[$campo])) {
            if (function_exists('url_amigable')) {
                $this->entradas[$campo] = url_amigable($this->entradas[$campo]);
            } else {
                $this->entradas[$campo] = filter_var($this->entradas[$campo], FILTER_SANITIZE_URL);
            }
        } else {
            $this->agr_error($campo, 'No existe el campo ' . $campo);
        }
    }

    public function url($campo = '') {
        if (isset($this->entradas[$campo])) {
            $this->entradas[$campo] = filter_var($this->entradas[$campo], FILTER_SANITIZE_URL);
        } else {
            $this->agr_error($campo, 'No existe el campo ' . $campo);
        }
    }

    public function obt_post($nom = '') {
        unset($this->entradas['token']);
        if (count($_POST) > 0) {
            if (!empty($nom)) {
                if (!array_key_exists($nom, $_POST)) {
                    return '';
                } else {
                    return $this->entradas[$nom];
                }
            } else {
                return $this->entradas;
            }
        } else {
            return $this->entradas;
        }
    }

    public function campos($nom = '') {
        unset($this->entradas['token']);
        if (count($_POST) > 0) {
            if (!empty($nom)) {
                if (!array_key_exists($nom, $_POST)) {
                    return '';
                } else {
                    return $this->entradas[$nom];
                }
            } else {
                return (object) $this->entradas;
            }
        } else {
            return (object) $this->entradas;
        }
    }

    public function obt_alias($value = '') {
        if (array_key_exists($value, $this->alias)) {
            return $this->alias[$value];
        } else {
            return $value;
        }
    }

    public function env_csrf() {
        $pk = obt_coleccion('sistema\librerias\sesion');
        $pk->env_csrf();
    }

    public function borrar_csrf() {
        $pk = obt_coleccion('sistema\librerias\sesion');
        $pk->borrar_csrf();
    }
    public function obt_entradas()
    {
        $entradas = array();
        $texto = html_entity_decode(@file_get_contents('php://input'), ENT_QUOTES, "UTF-8");

        switch (es_metodo()) {
          case 'POST':
              if (count($_POST)>0) {
                $entradas = array_merge($entradas,$_POST);
              }else{
                $otros = (array) json_decode($texto);
                if (count($otros) > 0) {
                  $entradas = array_merge($entradas,$otros);;
                }
              }
              break;

          case 'GET':
              $entradas = array_merge($entradas,$_GET);
              break;

          case 'PUT':
              $otros = (array) json_decode($texto);

              if (count($otros)>0) {
                $entradas = array_merge($entradas,$otros);
              }else{
                parse_str($texto,$entradas);
              }
              $entradas = array_merge($entradas,$_GET);
              break;

          default:
              $otros = (array) $texto;
              if (count($otros) > 0) {
                $entradas = array_merge($entradas,$otros);;
              }
              break;
        }
        if (isset($entradas['url'])) {
          unset($entradas['url']);
        }

        PK_Controlador::obt_instancia()->ayudas('limpiador');

        return sanear($entradas);
    }
}
