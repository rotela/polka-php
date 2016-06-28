<?php

namespace sistema\librerias;

use sistema\nucleo\PK_Config as PK_Config;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

class candado {

    private $clave;

    public function __construct() {
        $this->clave = PK_Config::obt_instancia()->obtener('aplicacion')->clave_can;
    }

    public function cerrar($valor = '', $clave = '') {
        $clave      = empty($clave) ? $this->clave : $clave;
        $iv_size    = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $encriptado = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $clave, $valor, MCRYPT_MODE_ECB, $iv_size);
        return (empty($valor)) ? '' : base64_encode($encriptado);
    }

    public function abrir($valor = '', $clave = '') {
        $clave      = empty($clave) ? $this->clave : $clave;
        $iv_size    = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $decriptado = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $clave, base64_decode($valor), MCRYPT_MODE_ECB, $iv_size);
        $decriptado = preg_replace("/[^A-z ÁÉÍÓÚÑáéíóúñ0-9]/i", "", $decriptado);
        return (empty($valor)) ? '' : $decriptado;
    }

}
