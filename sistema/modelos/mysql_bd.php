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
            $id_primario = $this->con->obt_id_primario();
            $tabla = $this->con->obt_tabla();
            if (empty($id_primario)) {
                $sql = "select * from $tabla limit 1";
                $result = $this->con->ejecutar($sql, false);
                if ($result) {
                    $f = $result[0];
                    foreach ($f as $key => $value) {
                        $id_primario = $key;
                        break;
                    }
                }
            }

            $sql = "select * from $tabla order by $id_primario desc limit 1";
            
            $result = $this->con->ejecutar($sql, false);
            
            if ($result) {
                $f = $result[0];
                foreach ($f as $key => $value) {
                    $ult_id = $value;
                    break;
                }
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
    //
    public function describir_tabla($tabla = '')
    {
        //$tabla = strtoupper($tabla);
        $sql = "DESCRIBE $tabla";
        return $this->con->ejecutar($sql);
    }
}
