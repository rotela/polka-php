<?php
namespace sistema\modelos;

interface bd_interface
{
    public function limite($limite = 0, $segmento = 0);
    public function obt_tablas($obt = true);
    public function obt_ult_id($secuencia = '');
    public function obt_campos();
    public function describir_tabla($tabla = '');
    public function obt_modelo_vacio($tabla = '');
}
