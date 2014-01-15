<?php
namespace sistema\librerias;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
class cronometro
{
    private $_partestiempo;
    private $_iniciotiempo;
    public function inicio() {
        $this->_partestiempo = explode(" ",microtime());
        $this->_iniciotiempo = $this->_partestiempo[1].substr($this->_partestiempo[0],1);
        $this->_partestiempo = explode(" ",microtime());
    }
    public function fin() {
        $endtime = $this->_partestiempo[1].substr($this->_partestiempo[0],1);
        return bcsub($endtime,$this->_iniciotiempo,6);
    }
}