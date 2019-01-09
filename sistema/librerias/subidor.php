<?php

namespace sistema\librerias;

class subidor
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
            'size' => 'peso',
        );
        if (array_key_exists($termino, $sinonimo)) {
            return $sinonimo[$termino];
        } else {
            return $termino;
        }
    }

    public function obt_error($value = '')
    {
        return $this->errores;
    }

    public function obt_reporte($value = '')
    {
        $this->reporte['kb'] = round($this->reporte['peso'] / 1024);
        return $this->reporte;
    }
}
