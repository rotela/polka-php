<?php
namespace sistema\modelos;

use \PDO;
use \PDOException;
use \Exception;

class sqlite_bd implements bd_interface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }
    public function insertar($datos = array(), $simular = false)
    {
        // se filtran los datos propios de la tabla
        $campos = $this->con->obt_campos();
        $datos = obt_arreglo($campos, $datos);
        //
        $campo_primario = $this->con->obt_cam_primario();
        if (isset($datos[$campo_primario])) {
            unset($datos[$campo_primario]);
        }
        // se arma la plantilla
        $orden = 'INSERT INTO '.$this->con->obt_tabla().' (';
        foreach ($datos as $campo => $valor) {
            if ($valor != 'NULL') {
                $orden .= $campo.', ';
            }
        }
        $orden .= ') VALUES (';
        foreach ($datos as $campo => $valor) {
            if ($valor != 'NULL') {
                $orden .= ':'.$campo.', ';
            }
        }
        $orden .= ')';
        // se limpia
        $this->con->orden = str_replace(', )', ')', $orden);
        $this->con->orden_hist[] = $this->con->orden;
        // se prepara la plantilla
        $sentencia = $this->con->prepare($this->con->orden);
        // se arma la fila con los datos ingresados
        $fila = array();
        foreach ($datos as $campo => $valor) {
            if ($valor != 'NULL') {
                $fila[':'.$campo] = $valor;
            }
        }
        // se ejecuta
        $estado = $sentencia->execute($fila);
        if ($simular) {
            return $this->con->armar_sql_insert($datos);
        } else {
            if ($this->con->comprobar($estado)) {
                $this->con->ultimo_id = $this->con->obt_ult_id();
                return $estado;
            }
        }
    }
    public function editar($datos = array(), $clave = array(), $simular = false)
    {
        // se obtiene solo los campos correspondiente a la tabla
        $campos = $this->con->obt_campos();
        $datos = obt_arreglo($campos, $datos);
        // se arma la plantilla
        $orden = 'UPDATE '.$this->con->obt_tabla().' SET ';
        foreach ($datos as $campo => $valor) {
            if ($valor != 'NULL') {
                $orden .= $campo.'=:'.$campo.', ';
            }
        }
        $orden .= 'WHERE ';
        foreach ($clave as $key => $value) {
            $orden .= $key.'='.$value.' AND ';
        }
        $orden = preg_replace('/AND $/', '', $orden);
        $orden = str_replace(', WHERE', ' WHERE', $orden);
        $this->con->orden = $orden;
        // se prepara la plantilla
        $sentencia = $this->con->prepare($this->con->orden);
        // se arma la fila con los datos ingresados
        $fila = array();
        foreach ($datos as $campo => $valor) {
            if ($valor != 'NULL') {
                $fila[':'.$campo] = $valor;
            }
        }
        // se ejecuta
        $estado = $sentencia->execute($fila);
        if ($simular) {
            $sql = $this->con->armar_sql_insert($datos);
            return $sql;
        } else {
            if ($this->con->comprobar($estado)) {
                $this->con->ultimo_id = $this->con->obt_ult_id();
                return $estado;
            }
        }
    }
    public function ejecutar($orden = '', $objeto = false)
    {
        $this->con->orden = $orden;
        $resultado = $this->con->query($this->con->orden);
        if ($this->con->comprobar($resultado)) {
            $this->cant_filas = $resultado->rowCount();
            if ($objeto) {
                return $resultado->fetchall(PDO::FETCH_OBJ);
            } else {
                return $resultado->fetchall(PDO::FETCH_ASSOC);
            }
        }
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
    public function obt_modelo_vacio($tabla='')
    {
    }
}
