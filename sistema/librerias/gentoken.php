<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

/**
 * clase generadora manejo de token.
 */
class gentoken
{
    private $clave;
    private $segundos;
    private $candado;

    public function __construct()
    {
        $ap = obt_config('aplicacion');
        $this->clave = $ap->clave_can;
        $this->segundos = $ap->ses_tiempo;
        $this->candado = new candado();
    }

    public function generar(array $datos = array(), string $clave = '', int $tiempo = 0): string
    {
        $s = ($tiempo > 0) ? $tiempo : $this->segundos;
        $c = (!empty($clave)) ? $clave : $this->clave;
        $datos['id'] = '1';
        $datos['inicio'] = time();
        $datos['expira'] = time() + $s;
        $datos['ip'] = cliente_ip();
        $texto = '';

        foreach ($datos as $key => $value) {
            $texto .= $key . ':' . $value . ';';
        }
        $token = $this->candado->cerrar($texto, $c);

        return $token;
    }

    public function explorar(string $token = '', string $clave = ''): array
    {
        $c = (!empty($clave)) ? $clave : $this->clave;
        $d = $this->candado->abrir($token, $c);
        $r = array();
        if (strpos($d, ';') !== false) {
            $a = explode(';', $d);
            foreach ($a as $value) {
                if (strpos($value, ':') !== false) {
                    $i = explode(':', $value);
                    $r[$i[0]] = $i[1];
                }
            }
        }

        if (count($r) > 0) {
            $r['expirado'] = ($r['expira'] < time());
        }
        return $r;
    }

    public function expirado(string $token = '', string $clave = '')
    {
        $expirado = false;
        $datos = $this->explorar($token, $clave);
        if (count($datos) > 0) {
            $expirado = ($datos['expira'] < time());
        }

        return $expirado;
    }
}
