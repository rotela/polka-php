<?php

namespace sistema\librerias;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

class candado
{
    private $clave;

    public function __construct()
    {
        $this->clave = obt_config('aplicacion')->clave_can;
    }
    public function procesar($accion, $entrada = '', $clave = '')
    {
        $output = false;
        $encrypt_metodo = "AES-256-CBC";
        $clave_secreta = (empty($clave)) ? $this->clave : $clave;
        $iv_secreto = $this->clave;
        $key = hash('sha256', $clave_secreta);
        $iv = substr(hash('sha256', $iv_secreto), 0, 16);
        if ($accion == 'cerrar') {
            $output = openssl_encrypt($entrada, $encrypt_metodo, $key, 0, $iv);
            $output = base64_encode($output);
        } elseif ($accion == 'abrir') {
            $output = openssl_decrypt(base64_decode($entrada), $encrypt_metodo, $key, 0, $iv);
        }
        return $output;
    }

    public function abrir($valor = '', $clave = '')
    {
        return $this->procesar('abrir', $valor, $clave);
    }

    public function cerrar($valor = '', $clave = '')
    {
        return $this->procesar('cerrar', $valor, $clave);
    }

    private function pad_key($key)
    {
        // si key es muy largo
        if (strlen($key) > 32) {
            return false;
        }
        // definiendo largor
        $sizes = array(16, 24, 32);

        foreach ($sizes as $s) {
            // se recorre cada largor y se compara con el de la clave, por cada
            // largor menor se agrega una cadena "\0"
            while (strlen($key) < $s) {
                $key = $key."\0";
            }
            // terminando si la clave encuentra su valor
            if (strlen($key) == $s) {
                break;
            }
        }

        return $key;
    }
}
