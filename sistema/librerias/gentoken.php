<?php
namespace sistema\librerias;

/**
 * clase generadora manejo de token
 */
class gentoken
{
    private $clave;
    private $segundos;
    private $candado;

    function __construct()
    {
        $ap = obt_config('aplicacion');
        $this->clave = $ap->clave_can;
        $this->segundos = $ap->ses_tiempo;
        $this->candado = obt_coleccion('sistema\librerias\candado');
    }
    public function generar($datos=array(),$clave='',$tiempo=0)
    {
        $s = ($tiempo > 0) ? $tiempo : $this->segundos;
        $c = (!empty($clave)) ? $clave : $this->clave;
        $datos['id'] = 'TemetNosce';
        $datos['inicio'] = time();
        $datos['expira'] = time() + $s;
        $texto ='';
        foreach ($datos as $key => $value) {
            $texto .= $key.':'.$value.';';
        }

        $token = $this->candado->cerrar($texto,$c);
        return $token;
    }
    public function explorar($token='',$clave='')
    {
        $c = (!empty($clave)) ? $clave : $this->clave;
        $d = $this->candado->abrir($token,$c);
        $r = array();
        if (strpos($d, ';') !== false) {
            $a = explode(';',$d);
            foreach ($a as $key => $value) {
                if (strpos($value,':') !== false) {
                    $i = explode(':',$value);
                    $r[$i[0]]=$i[1];
                }
            }
        }
        return $r;
    }
}