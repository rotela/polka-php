<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

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
}
