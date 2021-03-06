<?php
namespace sistema\modelos;

use \Exception;
use \PDO;
use \PDOException;

class firebird_bd implements bd_interface
{
    private $con;
    private $config;
    private $campos;
    private $descripcion;
    private $tablas;
    private $modelo_vacio;

    public function __construct($con)
    {
        $this->con = $con;
        $this->config = $this->con->obt_config();
        $this->campos = array();
        $this->descripcion = array();
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
        $orden = 'INSERT INTO ' . $this->con->obt_tabla() . ' (';
        foreach ($datos as $campo => $valor) {
            if ($valor !== 'NULL') {
                $orden .= $campo . ', ';
            }
        }
        $orden .= ') VALUES (';
        foreach ($datos as $campo => $valor) {
            if ($valor !== 'NULL') {
                $orden .= ':' . $campo . ', ';
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
                    $fila[':' . $campo] = $valor;
                    // $fila[':' . $campo] = mb_convert_encoding($valor, "ISO-8859-1");
                }
            }
            //
            if ($this->config->informar_sql) {
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
            //
            if ($this->config->mostrar_error) {
                informe($this->con->armar_sql_insert($datos));
            }
            $this->devolver_error($e);
        } catch (Exception $e) {
            //
            if ($this->config->mostrar_error) {
                informe($this->con->armar_sql_insert($datos));
            }
            $this->devolver_error($e);
        }
    }

    public function editar($datos = array(), $clave = array(), $simular = false)
    {
        // se obtiene solo los campos correspondiente a la tabla
        $campos = $this->con->obt_campos();
        $datos = obt_arreglo($campos, $datos);
        unset($datos['0']);
        // se arma la plantilla
        $orden = 'UPDATE ' . $this->con->obt_tabla() . ' SET ';
        foreach ($datos as $campo => $valor) {
            if ($valor !== 'NULL') {
                $orden .= $campo . '=:' . $campo . ', ';
            }
        }
        $orden .= 'WHERE ';
        foreach ($clave as $key => $value) {
            if ($value !== 'NULL') {
                $orden .= $key . '=' . $value . ' AND ';
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
                    $fila[':' . $campo] = $valor;
                }
            }
            //
            if ($this->config->informar_sql) {
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
            if ($this->config->mostrar_error) {
                informe($this->con->armar_sql_editar($datos, $clave));
            }
            $this->devolver_error($e);
        } catch (Exception $e) {
            if ($this->config->mostrar_error) {
                informe($this->con->armar_sql_editar($datos, $clave));
            }
            $this->devolver_error($e);
        }
    }

    public function ejecutar($orden = '', $objeto = false)
    {
        try {
            // $this->con->env_orden(mb_convert_encoding($orden, "ISO-8859-1"));
            // $resultado = $this->con->query($this->con->obt_orden());
            $this->con->orden = $orden;
            $resultado = $this->con->query($this->con->orden);
            if ($this->config->informar_sql) {
                informe($this->con->orden);
            }
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
        if (count($this->campos) <= 0) {
            $this->campos = array_keys($this->obt_modelo_vacio());
        }
        return $this->campos;
    }

    public function obt_ult_id($generador = '')
    {
        try {
            $ult_id = 0;
            if (empty($generador)) {
                $tabla = $this->con->obt_tabla();
                $campo_primario = $this->con->obt_cam_primario();
                $sql = "SELECT MAX($campo_primario) as ULT_ID from $tabla";
                $result = $this->con->ejecutar($sql);
                if ($result) {
                    $f = $result[0];
                    $ult_id = $f['ULT_ID'];
                }
            } else {
                $result = $this->con->ejecutar("SELECT gen_id($generador, 0) AS GEN_ID from rdb\$database");
                if ($result) {
                    $f = $result[0];
                    $ult_id = $f['GEN_ID'];
                }
            }
            return $ult_id;
        } catch (PDOException $e) {
            $this->devolver_error($e);
        } catch (Exception $e) {
            $this->devolver_error($e);
        }
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
        if (count($this->descripcion) <= 0) {
            $tabla = strtoupper($tabla);
            $sql = "SELECT
	RF.RDB\$RELATION_NAME FELD_TABLE,
	trim(RF.RDB\$FIELD_NAME) CAMPO,
	RF.RDB\$FIELD_POSITION FIELD_POSITION,
	CASE
		F.RDB\$FIELD_TYPE
		WHEN 7 THEN
		CASE
			F.RDB\$FIELD_SUB_TYPE
			WHEN 0 THEN 'SMALLINT'
			WHEN 1 THEN 'NUMERIC'
			WHEN 2 THEN 'DECIMAL'
		END
		WHEN 8 THEN
		CASE
			F.RDB\$FIELD_SUB_TYPE
			WHEN 0 THEN 'INTEGER'
			WHEN 1 THEN 'NUMERIC'
			WHEN 2 THEN 'DECIMAL'
		END
		WHEN 9 THEN 'QUAD'
		WHEN 10 THEN 'FLOAT'
		WHEN 12 THEN 'DATE'
		WHEN 13 THEN 'TIME'
		WHEN 14 THEN 'CHAR'
		WHEN 16 THEN
		CASE
			F.RDB\$FIELD_SUB_TYPE
			WHEN 0 THEN 'BIGINT'
			WHEN 1 THEN 'NUMERIC'
			WHEN 2 THEN 'DECIMAL'
		END
		WHEN 27 THEN 'DOUBLE'
		WHEN 35 THEN 'TIMESTAMP'
		WHEN 37 THEN 'VARCHAR'
		WHEN 40 THEN 'CSTRING'
		WHEN 45 THEN 'BLOB_ID'
		WHEN 261 THEN 'BLOB SUB_TYPE'
		ELSE 'RDB\$FIELD_TYPE: ' || F.RDB\$FIELD_TYPE || '?'
	END TIPO,
	IIF(COALESCE(RF.RDB\$NULL_FLAG,0) = 0, NULL, 'NOT NULL') FIELD_NULL,
	CH.RDB\$CHARACTER_SET_NAME FIELD_CHARSET,
	DCO.RDB\$COLLATION_NAME FIELD_COLLATION,
	COALESCE(RF.RDB\$DEFAULT_SOURCE,
	F.RDB\$DEFAULT_SOURCE) FIELD_DEFAULT,
	F.RDB\$VALIDATION_SOURCE FIELD_CHECK,
	RF.RDB\$DESCRIPTION FIELD_DESCRIPTION
FROM
	RDB\$RELATION_FIELDS RF
JOIN RDB\$FIELDS F ON
	(F.RDB\$FIELD_NAME = RF.RDB\$FIELD_SOURCE)
LEFT OUTER JOIN RDB\$CHARACTER_SETS CH ON
	(CH.RDB\$CHARACTER_SET_ID = F.RDB\$CHARACTER_SET_ID)
LEFT OUTER JOIN RDB\$COLLATIONS DCO ON
	((DCO.RDB\$COLLATION_ID = F.RDB\$COLLATION_ID)
	AND (DCO.RDB\$CHARACTER_SET_ID = F.RDB\$CHARACTER_SET_ID))
WHERE
	(COALESCE(RF.RDB\$SYSTEM_FLAG,
	0) = 0)
	AND RDB\$RELATION_NAME = '$tabla'
ORDER BY
	RF.RDB\$FIELD_POSITION";

            $this->descripcion = $this->con->ejecutar($sql);
        }

        return $this->descripcion;
    }

    public function obt_modelo_vacio($tabla = '')
    {
        if (count($this->modelo_vacio) > 0) {
            return $this->modelo_vacio;
        } else {
            $tabla = (empty($tabla)) ? strtoupper($this->con->obt_tabla()) : $tabla;

            $result = $this->describir_tabla($tabla);

            $array = array();

            foreach ($result as $key => $value) {
                $valor = '';
                switch (trim($value['FIELD_TYPE'])) {
                    case 'INTEGER':
                        $valor = 0;
                        break;
                    case 'SMALLINT':
                        $valor = 0;
                        break;
                    case 'FLOAT':
                        $valor = 0.0;
                        break;
                    case 'DOUBLE':
                        $valor = 0.0;
                        break;
                    case 'VARCHAR':
                        $valor = '';
                        break;
                    case 'CHAR':
                        $valor = '';
                        break;
                    case 'DATE':
                        $valor = '';
                        break;
                    case 'DECIMAL':
                        $valor = 0.0;
                        break;
                    default:
                        $valor = '';
                        break;
                }
                $array[$value['FIELD_NAME']] = $valor;
            }

            $this->modelo_vacio = $array;
            return $this->modelo_vacio;
        }
    }
    public function devolver_error($e)
    {
        if (isset($this->config)) {
            if (isset($this->config->mostrar_error)) {
                if ($this->config->mostrar_error) {
                    exit(mostrar_error('Modelo', utf8_encode($e->getMessage())));
                } else {
                    informe(utf8_encode('Modelo: ' . $e->getMessage()));
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
