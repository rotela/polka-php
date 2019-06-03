<?php
namespace sistema\librerias;

/**
 * Clase que supervisa parámetros requeridos para validaciones
 */
class requeridos
{
    private $errores;
    private $entradas;

    function __construct($entradas = array())
    {
        $this->entradas = $entradas;
        $this->errores = array();
    }
    public function agregar($datos = array(), $estricto = false)
    {
        foreach ($datos as $key => $value) {
            if (!array_key_exists($key, $this->entradas)) {
                array_push($this->errores, $value);
            } else {
                if ($estricto) {
                    switch (tipo_var($this->entradas[$key])) {
                        case 'string':
                            if (empty($this->entradas[$key])) {
                                array_push($this->errores, $value);
                            }
                            break;

                        case 'var':
                            if (empty($this->entradas[$key])) {
                                array_push($this->errores, $value);
                            }
                            break;

                        case 'integer':
                            if ($this->entradas[$key] <= 0) {
                                array_push($this->errores, $value);
                            }
                            break;

                        case 'int':
                            if ($this->entradas[$key] <= 0) {
                                array_push($this->errores, $value);
                            }
                            break;

                        case 'numeric':
                            if ($this->entradas[$key] <= 0) {
                                array_push($this->errores, $value);
                            }
                            break;

                        case 'float':
                            if ($this->entradas[$key] <= 0.0) {
                                array_push($this->errores, $value);
                            }
                            break;

                        case 'double':
                            if ($this->entradas[$key] <= 0.0) {
                                array_push($this->errores, $value);
                            }
                            break;

                        default:
                            if (empty($this->entradas[$key])) {
                                array_push($errores, $value);
                            }
                            break;
                    }
                }
            }
        }
    }
    public function verificar()
    {
        return (count($this->errores) == 0) ? true : false;
    }
    public function obt_errores()
    {
        return $this->errores;
    }
}
