<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

class imagen
{
    private $errores = array();
    private $reporte = array();

    public function __construct()
    {
    }

    public function subir($config = array())
    {
        if (!array_key_exists('destino', $config)) {
            $this->errores[] = 'No se ha definido el destino del fichero';
            return false;
        } else {
            if (!is_dir($config['destino'])) {
                $this->errores['mensaje'] = 'El destino no es válido';
                return false;
            }
        }

        if (!array_key_exists('campo', $config)) {
            $this->errores[] = 'No se ha definido el nombre del campo';
            return false;
        }

        $campo = $config['campo'];

        if (!isset($_FILES[$campo]['name'])) {
            $this->errores[] = "No se existe el campo: $campo o no se pudo subir";
            return false;
        }

        $uploaddir = str_replace('\\', SD, $config['destino']);
        $campo = $config['campo'];
        $uploadfile = $uploaddir.basename($_FILES[$campo]['name']);

        foreach ($_FILES as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $ind => $valor) {
                    $this->reporte[$this->sinn($ind)] = $valor;
                }
            } else {
                $this->reporte[$this->sinn($key)] = $value;
            }
        }

        if (move_uploaded_file($_FILES[$campo]['tmp_name'], $uploadfile)) {
            $this->reporte['destino'] = $uploaddir;
            $this->reporte['mensaje'] = 'El archivo fue cargado exitosamente';
            $this->reporte['url'] = str_replace('\\', '/', $config['destino']).$this->reporte['nombre'];

            return true;
        } else {
            $this->errores['mensaje'] = 'El archivo sobre pasa lo máximo permitido';

            return false;
        }
    }

    private function sinn($termino = '')
    {
        $sinonimo = array(
            'name' => 'nombre',
            'type' => 'tipo',
            'tmp_name' => 'tmp_nombre',
            'error' => 'error',
            'size' => 'tamano',
        );
        if (array_key_exists($termino, $sinonimo)) {
            return $sinonimo[$termino];
        } else {
            return $termino;
        }
    }

    public function obt_error()
    {
        return $this->errores;
    }

    public function obt_reporte()
    {
        $this->reporte['kb'] = round($this->reporte['tamano'] / 1024);
        return $this->reporte;
    }
}
