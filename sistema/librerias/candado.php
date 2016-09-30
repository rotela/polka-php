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

    public function cerrar($valor = '', $clave = '')
    {
        $clave = empty($clave) ? $this->clave : $clave;
        $clave = $this->pad_key($clave);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $encriptado = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $clave, $valor, MCRYPT_MODE_ECB, $iv_size);

        return (empty($valor)) ? '' : base64_encode($encriptado);
    }

    public function abrir($valor = '', $clave = '')
    {
        $clave = empty($clave) ? $this->clave : $clave;
        $clave = $this->pad_key($clave);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $decriptado = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $clave, base64_decode($valor), MCRYPT_MODE_ECB, $iv_size);
        //$decriptado = preg_replace("/[^A-z ÁÉÍÓÚÑáéíóúñ0-9]/i", "", $decriptado);
        return (empty($valor)) ? '' : $decriptado;
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
