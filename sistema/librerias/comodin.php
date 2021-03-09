<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

class comodin
{
    /**  Localización de los datos sobrecargados.  */
    private $data = array();

    /**  La sobrecarga no se usa en propiedades declaradas.  */
    public $declared = 1;

    /**  La sobre carga sólo funciona aquí al acceder desde fuera de la clase.  */
    private $hidden = 2;

    public function __set($name, $value)
    {
        // Estableciendo '$name' a '$value';
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        // Consultando '$name';
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Propiedad indefinida mediante __get(): ' . $name .
            ' en ' . $trace[0]['file'] .
            ' en la línea ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**  Desde PHP 5.1.0  */
    public function __isset($name)
    {
        echo "¿Está definido '$name'?\n";
        return isset($this->data[$name]);
    }

    /**  Desde PHP 5.1.0  */
    public function __unset($name)
    {
        echo "Eliminando '$name'\n";
        unset($this->data[$name]);
    }

    /**  No es un método mágico, esta aquí para completar el ejemplo.  */
    public function getHidden()
    {
        return $this->hidden;
    }
}