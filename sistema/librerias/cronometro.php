<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

class cronometro
{
    private $partestiempo;
    private $iniciotiempo;

    public function inicio()
    {
        $this->partestiempo = explode(' ', microtime());
        $this->iniciotiempo = $this->partestiempo[1].substr($this->partestiempo[0], 1);
        $this->partestiempo = explode(' ', microtime());
    }

    public function fin()
    {
        $endtime = $this->partestiempo[1].substr($this->partestiempo[0], 1);

        return bcsub($endtime, $this->iniciotiempo, 6);
    }
}
