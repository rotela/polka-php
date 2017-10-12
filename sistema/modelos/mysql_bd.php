<?php
namespace sistema\modelos;

class mysql_bd implements bd_interface
{

    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }
    public function obt_campos()
    {
        $datos = array();
        $resultado = $this->describir_tabla($this->con->obt_tabla());
        foreach ($resultado as $key => $value) {
            $datos[] = $value->Field;
        }
        return $datos;
    }
    public function obt_ult_id($generador = '')
    {
        $ult_id = $this->con->lastInsertId();
        if ($ult_id == 0) {
            $campo_primario = $this->con->obt_cam_primario();
            $tabla = $this->con->obt_tabla();
            $sql = "select max($campo_primario) as ult_id from $tabla";
            $result = $this->con->ejecutar($sql);
           
            if ($result) {
                $f = $result[0];
                $ult_id = $f->ult_id;
            }
        }
        return $ult_id;
    }
    public function limite($limite = 0, $segmento = 0)
    {
    }
    public function obt_tablas($obt = true)
    {
    }
    public function describir_tabla($tabla = '')
    {
        $sql = "DESCRIBE $tabla";
        return $this->con->ejecutar($sql);
    }
}
