<?php
namespace sistema\modelos;

class firebird_bd implements bd_interface
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
            $datos[] = trim($value->FIELD_NAME);
        }
        return $datos;
    }
    public function obt_ult_id($generador = '')
    {
        $ult_id = 0;
        if (empty($generador)) {
            $id_primario = $this->con->obt_id_primario();

            if (empty($id_primario)) {
                $sql = "select first 1 * from ".$this->con->obt_tabla();

                $result = $this->con->ejecutar($sql, false);
                if ($result) {
                    $f = $result[0];
                    foreach ($f as $key => $value) {
                        $id_primario = $key;
                        break;
                    }
                }
            }

            $sql = "select first 1 * from ".$this->con->obt_tabla()." order by $id_primario desc";
            
            $result = $this->con->ejecutar($sql, false);
            
            if ($result) {
                $f = $result[0];
                foreach ($f as $key => $value) {
                    $ult_id = $value;
                    break;
                }
            }
        } else {
            $sql = "select gen_id($generador, 0) from rdb\$database";
            $result = $this->con->ejecutar($sql, false);
            if ($result) {
                $f = $result[0];
                $ult_id = $f['GEN_ID'];
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
        $tabla = strtoupper($tabla);
        $sql = "SELECT
  RF.RDB\$RELATION_NAME FELD_TABLE,
  RF.RDB\$FIELD_NAME FIELD_NAME,
  RF.RDB\$FIELD_POSITION FIELD_POSITION,
  CASE F.RDB\$FIELD_TYPE
    WHEN 7 THEN
      CASE F.RDB\$FIELD_SUB_TYPE
        WHEN 0 THEN 'SMALLINT'
        WHEN 1 THEN 'NUMERIC(' || F.RDB\$FIELD_PRECISION || ', ' || (-F.RDB\$FIELD_SCALE) || ')'
        WHEN 2 THEN 'DECIMAL'
      END
    WHEN 8 THEN
      CASE F.RDB\$FIELD_SUB_TYPE
        WHEN 0 THEN 'INTEGER'
        WHEN 1 THEN 'NUMERIC('  || F.RDB\$FIELD_PRECISION || ', ' || (-F.RDB\$FIELD_SCALE) || ')'
        WHEN 2 THEN 'DECIMAL'
      END
    WHEN 9 THEN 'QUAD'
    WHEN 10 THEN 'FLOAT'
    WHEN 12 THEN 'DATE'
    WHEN 13 THEN 'TIME'
    WHEN 14 THEN 'CHAR(' || (TRUNC(F.RDB\$FIELD_LENGTH / CH.RDB\$BYTES_PER_CHARACTER)) || ') '
    WHEN 16 THEN
      CASE F.RDB\$FIELD_SUB_TYPE
        WHEN 0 THEN 'BIGINT'
        WHEN 1 THEN 'NUMERIC(' || F.RDB\$FIELD_PRECISION || ', ' || (-F.RDB\$FIELD_SCALE) || ')'
        WHEN 2 THEN 'DECIMAL'
      END
    WHEN 27 THEN 'DOUBLE'
    WHEN 35 THEN 'TIMESTAMP'
    WHEN 37 THEN
     IIF (COALESCE(f.RDB\$COMPUTED_SOURCE,'')<>'',
      'COMPUTED BY ' || CAST(f.RDB\$COMPUTED_SOURCE AS VARCHAR(250)),
      'VARCHAR(' || (TRUNC(F.RDB\$FIELD_LENGTH / CH.RDB\$BYTES_PER_CHARACTER)) || ')')
    WHEN 40 THEN 'CSTRING' || (TRUNC(F.RDB\$FIELD_LENGTH / CH.RDB\$BYTES_PER_CHARACTER)) || ')'
    WHEN 45 THEN 'BLOB_ID'
    WHEN 261 THEN 'BLOB SUB_TYPE ' || F.RDB\$FIELD_SUB_TYPE
    ELSE 'RDB\$FIELD_TYPE: ' || F.RDB\$FIELD_TYPE || '?'
  END FIELD_TYPE,
  IIF(COALESCE(RF.RDB\$NULL_FLAG, 0) = 0, NULL, 'NOT NULL') FIELD_NULL,
  CH.RDB\$CHARACTER_SET_NAME FIELD_CHARSET,
  DCO.RDB\$COLLATION_NAME FIELD_COLLATION,
  COALESCE(RF.RDB\$DEFAULT_SOURCE, F.RDB\$DEFAULT_SOURCE) FIELD_DEFAULT,
  F.RDB\$VALIDATION_SOURCE FIELD_CHECK,
  RF.RDB\$DESCRIPTION FIELD_DESCRIPTION
FROM RDB\$RELATION_FIELDS RF
JOIN RDB\$FIELDS F ON (F.RDB\$FIELD_NAME = RF.RDB\$FIELD_SOURCE)
LEFT OUTER JOIN RDB\$CHARACTER_SETS CH ON (CH.RDB\$CHARACTER_SET_ID = F.RDB\$CHARACTER_SET_ID)
LEFT OUTER JOIN RDB\$COLLATIONS DCO ON ((DCO.RDB\$COLLATION_ID = F.RDB\$COLLATION_ID) AND (DCO.RDB\$CHARACTER_SET_ID = F.RDB\$CHARACTER_SET_ID))
WHERE (COALESCE(RF.RDB\$SYSTEM_FLAG, 0) = 0) AND RDB\$RELATION_NAME = '$tabla'
ORDER BY RF.RDB\$FIELD_POSITION";
        
        return $this->con->ejecutar($sql);
    }
}
