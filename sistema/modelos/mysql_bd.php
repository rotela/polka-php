<?php
namespace sistema\modelos;

use \PDO;
use \PDOException;
use \Exception;

class mysql_bd implements bd_interface
{
    private $con;
    private $config;
    private $campos;
    private $tablas;
    private $modelo_vacio;

    public function __construct($con)
    {
        $this->con = $con;
        $this->config = $this->con->obt_config();
        $this->campos = array();
        $this->tablas = array();
        $this->modelo_vacio = array();
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
            if ($valor !== 'NULL') {
                $orden .= $campo.', ';
            }
        }
        $orden .= ') VALUES (';
        foreach ($datos as $campo => $valor) {
            if ($valor !== 'NULL') {
                $orden .= ':'.$campo.', ';
            }
        }
        $orden .= ')';
        // se limpia
        $this->con->orden = str_replace(', )', ')', $orden);
        try {
            // se prepara la plantilla
            $sentencia = $this->con->prepare($this->con->orden);
            // se arma la fila con los datos ingresados
            $fila = array();
            foreach ($datos as $campo => $valor) {
                if ($valor !== 'NULL') {
                    $fila[':'.$campo] = mb_convert_encoding($valor, "ISO-8859-1");
                }
            }
            //
            if ($this->config->mostrar_error) {
                informe($this->con->armar_sql_insert($datos));
            }
            // se ejecuta
            if ($simular) {
                return $this->con->armar_sql_insert($datos);
            } else {
                $estado = $sentencia->execute($fila);
                if ($this->con->comprobar($estado)) {
                    $this->con->ultimo_id = $this->con->obt_ult_id();
                    return $estado;
                }
            }
        } catch (PDOException $e) {
            $this->devolver_error($e);
        } catch (Exception $e) {
            $this->devolver_error($e);
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
            if ($valor !== 'NULL') {
                $orden .= $campo.'=:'.$campo.', ';
            }
        }
        $orden .= 'WHERE ';
        foreach ($clave as $key => $value) {
            if ($valor !== 'NULL') {
                $orden .= $key.'='.$value.' AND ';
            }
        }
        $orden = preg_replace('/AND $/', '', $orden);
        $orden = str_replace(', WHERE', ' WHERE', $orden);
        $this->con->orden = $orden;

        try {
            // se prepara la plantilla
            $sentencia = $this->con->prepare($this->con->orden);
            // se arma la fila con los datos ingresados
            $fila = array();
            foreach ($datos as $campo => $valor) {
                if ($valor !== 'NULL') {
                    $fila[':'.$campo] = mb_convert_encoding($valor, "ISO-8859-1");
                }
            }
            //
            if ($this->config->mostrar_error) {
                informe($this->con->armar_sql_editar($datos, $clave));
            }
            // se ejecuta
            if ($simular) {
                return $this->con->armar_sql_editar($datos, $clave);
            } else {
                $estado = $sentencia->execute($fila);
                if ($this->con->comprobar($estado)) {
                    return $estado;
                }
            }
        } catch (PDOException $e) {
            $this->devolver_error($e);
        } catch (Exception $e) {
            $this->devolver_error($e);
        }
    }
    public function ejecutar($orden = '', $objeto = false)
    {
        if ($this->config->informar_sql) {
            informe($orden);
        }
        try {
            $this->con->orden = $orden;
            $resultado = $this->con->query($this->con->orden);

            if ($resultado) {
                $this->cant_filas = $resultado->rowCount();
                if ($objeto) {
                    return $resultado->fetchall(PDO::FETCH_OBJ);
                } else {
                    return $resultado->fetchall(PDO::FETCH_ASSOC);
                }
            } else {
                if ($this->config->mostrar_error) {
                    exit(mostrar_error('Modelo', utf8_encode($this->con->obt_error())));
                } else {
                    informe($this->con->orden);
                    informe($this->con->obt_error());
                    return false;
                }
            }
        } catch (PDOException $e) {
            $this->devolver_error($e);
        } catch (Exception $e) {
            $this->devolver_error($e);
        }
    }
    public function obt_campos()
    {
        return array_keys($this->obt_modelo_vacio());
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
                $ult_id = $f['ult_id'];
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
        $tabla = empty($tabla) ? $this->con->obt_tabla():$tabla;
        $sql = "DESCRIBE $tabla";
        return $this->con->ejecutar($sql);
    }
    public function obt_modelo_vacio($tabla = '')
    {
        $result = $this->describir_tabla();

        $array = array();

        foreach ($result as $key => $value) {
            $valor = '';
            $tipo = explode('(', trim($value['Type']));
            $tipo = $tipo[0];
            switch ($tipo) {
                case 'int':
                    $valor = 0;
                    break;
                case 'smallint':
                    $valor = 0;
                    break;
                case 'decimal':
                    $valor = 0.0;
                    break;
                case 'var':
                    $valor = '';
                    break;
                case 'varchar':
                    $valor = '';
                    break;
                case 'char':
                    $valor = '';
                    break;
                case 'date':
                    $valor = '';
                    break;
                case 'DECIMAL':
                    $valor = 0.0;
                    break;
                default:
                    $valor = '';
                    break;
            }
            $array[$value['Field']] = $valor;
        }
        return $array;
    }
    public function devolver_error($e)
    {
        if (isset($this->config)) {
            if (isset($this->config->mostrar_error)) {
                if ($this->config->mostrar_error) {
                    exit(mostrar_error('Modelo', utf8_encode($e->getMessage())));
                } else {
                    informe(utf8_encode('Modelo: '.$e->getMessage()));
                    return false;
                }
            } else {
                exit(mostrar_error('Modelo', utf8_encode($e->getMessage())));
            }
        } else {
            exit(mostrar_error('Modelo', utf8_encode($e->getMessage())));
        }
    }
}
