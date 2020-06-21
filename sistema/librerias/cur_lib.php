<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

class cur_lib
{
    public function __construct()
    {
    }

    private function serializar(array $campos = array())
    {
        $elementos = array();
        foreach ($campos as $nombre => $valor) {
            $elementos[$nombre] = urlencode($valor);
        }

        return $elementos;
    }

    public function obtener(string $url = '', array $datos = array(), bool $arreglo = false)
    {
        $manejador = curl_init();
        curl_setopt($manejador, CURLOPT_URL, $url);
        if (count($datos) > 0) {
            $elementos = $this->serializar($datos);
            curl_setopt($manejador, CURLOPT_POST, true);
            curl_setopt($manejador, CURLOPT_POSTFIELDS, $elementos);
        }
        curl_setopt($manejador, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($manejador);
        $recibido = ($arreglo) ? json_decode($respuesta, true) : $respuesta;
        curl_close($manejador);

        return $recibido;
    }
}
