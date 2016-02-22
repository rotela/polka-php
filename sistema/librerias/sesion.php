<?php

namespace sistema\librerias;

defined('SISTEMA') or exit('No se permite el acceso directo al script.');

class sesion {

    private $id = '';
    private $nom_alerta = 'nom_alerta';

    public function __construct() {
        if (!isset($_SESSION['sesion_id'])) {
            $sesion = obt_config('aplicacion');
            //session_set_cookie_params($sesion->ses_tiempo,'/',url_base(),true,true);
            @session_start();
            $this->id = session_id();
            $_SESSION['sesion_id'] = $this->id;
            // destruyo las alertas temporales
            $this->destruir_alerta();
            // compruebo la expiración
            $this->expiracion($sesion->ses_tiempo);
        }
    }

    private function expiracion($tiempo = 0) {
        if (isset($_SESSION['sesion_id'])) {
            if ($tiempo) {
                if (!isset($_SESSION['expira'])) {
                    $_SESSION['expira'] = time() + $tiempo;
                } else {
                    if (time() > $_SESSION['expira'])
                        $this->destruir();
                }
            }
            else {
                $_SESSION['expira'] = time() + 7200;
            }
        }
    }

    public function destruir_alerta() {
        if (isset($_SESSION['marca'])) {
            $marca = $_SESSION['marca'];
            $marca--;
            if ($marca == 0) {
                unset($_SESSION['marca']);
                if (isset($_SESSION[$this->nom_alerta])) {
                    $clave_alerta = $_SESSION[$this->nom_alerta];
                    if (isset($_SESSION[$clave_alerta])) {
                        unset($_SESSION[$clave_alerta]);
                    }
                }
            } else {
                $_SESSION['marca'] = $marca;
            }
        }
    }

    public function destruir($clave = array()) {
        if (is_array($clave)) {
            if (count($clave) > 0) {
                foreach ($clave as $value) {
                    if (isset($_SESSION[$value])) {
                        unset($_SESSION[$value]);
                    }
                }
            } else {
                session_destroy();
            }
        } else {
            unset($_SESSION[$clave]);
        }
    }

    public function obt_id() {
        return $this->id;
    }

    public function obt_datos($clave = '') {
        if (!empty($clave)) {
            return isset($_SESSION[$clave]) ? $_SESSION[$clave] : '';
        } else {
            return $_SESSION;
        }
    }

    public function env_datos($datos = '', $clave = '') {
        if (!empty($datos)) {
            if (is_array($datos)) {
                foreach ($datos as $nombre => $valor) {
                    $_SESSION[$nombre] = $valor;
                }
            } else {
                if (!empty($clave)) {
                    $_SESSION[$clave] = $datos;
                } else {
                    exit(mostrar_error('Sesión', 'Se requiere la clave para la sesión.'));
                }
            }
        } else {
            exit(mostrar_error('Sesión', 'Se requiere de los datos para la sesión.'));
        }
    }

    public function env_dato_temp($mensaje = '', $clave = '') {
        if (!empty($mensaje)) {
            $_SESSION[$clave] = $mensaje;
            $_SESSION[$this->nom_alerta] = $clave;
            $_SESSION['marca'] = 2;
        }
    }

    public function obt_dato_temp($clave = '') {
        $mensaje = '';
        if (isset($_SESSION[$clave])) {
            $mensaje = $_SESSION[$clave];
            unset($_SESSION[$clave]);
        }
        return $mensaje;
    }

    public function env_csrf() {
        $csrf_nom = obt_config('aplicacion')->csrf_nom;
        $_SESSION[$csrf_nom] = md5(uniqid(mt_rand(), true));
    }

    public function borrar_csrf() {
        $csrf_nom = obt_config('aplicacion')->csrf_nom;
        if (isset($_SESSION[$csrf_nom])) {
            unset($_SESSION[$csrf_nom]);
        }
    }

}
