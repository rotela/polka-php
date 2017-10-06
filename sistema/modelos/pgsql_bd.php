<?php
namespace sistema\modelos;

class pgsql_bd implements bd_interface
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
            $datos[] = trim($value->column_name);
        }
        return $datos;
    }
    public function obt_ult_id($generador = '')
    {
        $ult_id = 0;
        if (empty($generador)) {
            $tabla = $this->con->obt_tabla();
            $campo_primario = $this->con->obt_cam_primario();
            $sql = "select max($campo_primario) as ult_id from prioridades";
            $result = $this->con->ejecutar($sql);
            if ($result) {
                $f = $result[0];
                foreach ($f as $key => $value) {
                    $ult_id = $value;
                    break;
                }
            }
        } else {
            $sql = "select setval('$generador', nextval('$generador') - 1, true) as id";

            $result = $this->con->ejecutar($sql);
            if ($result) {
                $f = $result[0];
                $ult_id = $f->id;
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
        $sql = "select column_name, data_type, character_maximum_length 
        from INFORMATION_SCHEMA.COLUMNS where table_name = '$tabla'";
        $result = $this->con->ejecutar($sql);
        
        return $result;
    }
}
