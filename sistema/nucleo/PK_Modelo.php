<?php
namespace sistema\nucleo;

if (!defined('SISTEMA')) {
    exit('No se permite acceso directo al script');
}

use sistema\nucleo\PK_Conexion;
use sistema\librerias\estructura_bd;
use \PDO;
use \PDOException;
use \Exception;

/**
 * Modelo Principal del Sistema
 * De ésta debe extenderse los modelos del usuario,
 * de esa forma tendrá heredadas todos los métodos o funciones
 * que contienen ésta clase.
 *
 * CONFIGURACION
 *
 * Configurar la Base de Datos en aplicacion/configuracion/bd.php
 *
 * ATENCION
 * No tocar las propiedades de ésta clase
 * Si desea configurar su Base de Datos, hacer lo indicado anteriormente
 *
 * @copyright Rotelabs (c)2017
 * @author Ricardo Rotela <rotelabs->gmail.com>
 *
 * @version 2.0 2017/08/30
 */
class PK_Modelo extends PK_Conexion
{
    /**
     * Contenedor del Nombre de la tabla con la cual construír
     * el Modelo.
     *
     * @var string
     */
    private $tabla = '';
    /**
     * Contenedor del Nombre id principal de la tabla
     *
     * @var string
     */
    private $cam_primario = '';

    /**
     * Contenedor de Nombres de las Tablas contenidas en la bd.
     *
     * @var array
     */
    private $tablas = array();

    /**
     * Contenedor de los Nombre de Columnas.
     *
     * @var array
     */
    private $campos = array();

    /**
     * Cantidad de filas dovolvidas por alguna consulta.
     *
     * @var int
     */
    private $cant_filas = 0;

    /**
     * Ultimo id del registro que se haya insertado (sólo mysql).
     *
     * @var int
     */
    private $ultimo_id = 0;

    /**
     * Contenedor de datos de registro generados por alguna consulta
     * dependiendo si es un arreglo tipo array u objeto.
     *
     * @var array
     */
    public $datos = array();

    /**
     * Contenedor de la última sentencia SQL ejecutada.
     *
     * @var string
     */
    private $orden = '';

    /**
     * Contenedor de sentencias SQL de forma de array, segmentadas.
     *
     * @var array
     */
    private $orden_l = array();

    /**
     * Contenedor de todas las órdenes SQL ejecutadas en una instancia.
     *
     * @var array
     */
    private $orden_hist = array();

    /**
     * Contenedor del error/es.
     *
     * @var string
     */
    private $error = '';

    /**
     * Contiene todas las columnas de una fila.
     *
     * @var array
     */
    public $fila = array();

    /**
     * Propiedad protegida para las instanciaciones.
     *
     * @var [type]
     */
    protected $tg;

    /**
     * Propiedad protegida para las configuraciones.
     *
     * @var [array]
     */
    protected $config;
    /*
    * Se utiliza Singleton para instanciar fuera del controlador
    */
    use PK_Singleton;

    /**
    * instancia de referencia de las interfaces
    */
    private $bd_interface;

    /**
     * El contructor requiere o espera el nombre de la tabla a utilizar
     * por el modelo, se debe indicar el nombre de la tabla
     * en el constructor del modelo hijo o clase hija.
     *
     * @param string $tabla [description]
     */
    public function __construct($tabla = '', $campo_primario = '')
    {
        parent::__construct();
        $this->bd_interface = $this->obt_interface();
        if (empty($tabla)) {
            throw new Exception(mostrar_error('Modelo', 'Se requiere del nombre de la tabla a utilizar por éste modelo.'));
        } else {
            $this->tabla = trim($tabla);
            $this->cam_primario = trim($campo_primario);
            $this->estructurar();
        }
    }
    /**
     * Se utiliza para asignar a un valor a un campo
     * como si fuera una funcion, ej.
     * $this->edad(30)
     * Esta función es utilizada con la función guardar().
     *
     * @param  string $nombre    Nombre de la función (nombre del campo o columna)
     * @param  mixed $parametro Parámetro de la función
     */
    public function __call($nombre, $parametro)
    {
        if (empty($this->campos)) {
            $this->obt_campos();
        }
        if (in_array($nombre, $this->campos)) {
            $this->datos[$nombre] = $parametro[0];
        } else {
            throw new Exception(mostrar_error('Modelo', "Función <strong>'$nombre'</strong></strong> desconocida o no existe el campo <strong>'$nombre'</strong>"));
        }
    }

    /**
     * Función para obtener datos de una columna específica
     * Ej.
     * echo $this->edad
     * Esta función es utilizada despues de ejecutar una búsqueda
     * o consulta que devuelva un sólo registro.
     *
     * @param  [type] $propiedad Nombre de la propiedad a acceder
     *                           Nombre de la columna a acceder
     *
     * @return mixed            Según lo que contiene ésa propiedad o columna
     */
    public function __get($propiedad)
    {
        if (array_key_exists($propiedad, $this->fila)) {
            return $this->fila[$propiedad];
        } else {
            return '';
        }
    }


    public function estructurar()
    {
        $datos = $this->obt_descripcion();
        obt_coleccion('sistema\librerias\estructura_bd')::obt_instancia()->escribir($datos, $this->tabla);
    }
    /**
     * Devuelve la fila del registro encontrado, y sus columnas como propiedades
     * Esta función es utilizada después de una búsqueda o consulta
     * anterior.
     *
     * @return object Objecto de la fila encontrada
     */
    public function obt_fila()
    {
        return $this->fila;
    }
    public function armar_sql_insert($datos = array(), $tabla = '')
    {
        $sql = '';
        $campos = '';
        $valores = '';
        $primer = 0;
        foreach ($datos as $key => $value) {
            switch (tipo_var($value)) {
                case 'string':
                    $valor = "'$value'";
                    break;
                case 'char':
                    $valor = "'$value'";
                    break;
                case 'varchar':
                    $valor = "'$value'";
                    break;
                case 'numeric':
                    $valor = $value;
                    break;
                case 'decimal':
                    $valor = $value;
                    break;
                case 'double':
                    $valor = $value;
                    break;
                case 'integer':
                    $valor = $value;
                    break;
                case 'int':
                    $valor = $value;
                    break;
                case 'tinyint':
                    $valor = $value;
                    break;
                case 'float':
                    $valor = $value;
                    break;
                case 'boolean':
                    $valor = ($value == true) ? 1 : 0;
                    break;
                default:
                    $valor = $value;
                    break;
            }

            $campos .= empty($campos) ? $key : ','.$key;

            if ($primer == 0) {
                $valores = $valor;
            } else {
                $valores = $valores.','.$valor;
            }

            ++$primer;
        }

        $tabla = (empty($tabla)) ? $this->tabla : $tabla;

        $sql = 'INSERT INTO '.$tabla."($campos) VALUES($valores)";
        $sql = str_replace("'NULL'", 'NULL', $sql);

        return $sql;
    }
    public function armar_sql_editar($datos = array(), $mientras = array(), $tabla = '')
    {
        $sql = '';
        $campos = '';
        $valores = '';
        $primer = 0;
        foreach ($mientras as $key => $value) {
            if (array_key_exists($key, $datos)) {
                unset($datos[$key]);
            }
        }
        foreach ($datos as $key => $value) {
            switch (tipo_var($value)) {
                case 'string':
                    $valor = "'$value'";
                    break;
                case 'char':
                    $valor = "'$value'";
                    break;
                case 'varchar':
                    $valor = "'$value'";
                    break;
                case 'numeric':
                    $valor = $value;
                    break;
                case 'decimal':
                    $valor = $value;
                    break;
                case 'double':
                    $valor = $value;
                    break;
                case 'integer':
                    $valor = $value;
                    break;
                case 'int':
                    $valor = $value;
                    break;
                case 'tinyint':
                    $valor = $value;
                    break;
                case 'float':
                    $valor = $value;
                    break;
                case 'boolean':
                    $valor = ($value == true) ? 1 : 0;
                    break;
                default:
                    $valor = $value;
                    break;
            }
            if ($key !== 0) {
                // code...
                $campos .= empty($campos) ? $key.' = '.$valor : ', '.$key.' = '.$valor;
            }
        }

        $elwhere = '';

        foreach ($mientras as $key => $value) {
            $elwhere = $key.' = '.$value;
        }

        $tabla = (empty($tabla)) ? $this->tabla : $tabla;

        $sql = 'UPDATE '.$tabla." SET $campos WHERE $elwhere";
        $sql = str_replace("'NULL'", 'NULL', $sql);

        return $sql;
    }
    /**
     * Busca un registro con los datos pasados como parámetros,
     * Esta función es ideal para encontrar registros únicos o específicos
     * No se recomienda utilizar si se espera varios registros.
     *
     * @param  array   $datos  Parámetro de búsqueda ej.
     *                         $this->buscar_por(array('id'=>8));
     *                         Lo anterior buscará el registro con la columna
     *                         id = 8
     * @param bool          Se indica false si desea el resultado como array
     *                         asociativo o true en caso de objeto
     *
     * @return  mixed $objeto  Devuelve el resultado o false si no encontró
     */
    public function buscar_por($datos = array(), $objeto = false, $columnas = array())
    {
        // preparo la orden
        if (count($columnas) == 0) {
            $orden = 'SELECT * FROM '.$this->tabla.' WHERE ';
        } else {
            $orden = 'SELECT '.implode(', ', $columnas).' FROM '.$this->tabla.' WHERE ';
        }
        $m = '';
        foreach ($datos as $campos => $valor) {
            $m .= empty($m) ? $campos.'=:'.$campos : ' AND '.$campos.'=:'.$campos;
        }
        $orden .= $m;
        $this->orden = $orden;
        try {
            $query = $this->prepare($this->orden);
            // paso los parámetros
            foreach ($datos as $campo => $valor) {
                $query->bindValue(":$campo", $valor);
            }
            // ejecuto
            $resultados = $query->execute();
            // compruebo los resultados
            if ($this->comprobar($resultados)) {
                $fila = $query->fetchAll(PDO::FETCH_ASSOC);
                $this->cant_filas = count($fila);

                if ($this->cant_filas > 0) {
                    $this->fila = $fila[0];
                    if ($objeto) {
                        return (object) $this->fila;
                    } else {
                        return $this->fila;
                    }
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            $this->devolver_error($e);
        } catch (Exception $e) {
            $this->devolver_error($e);
        }
    }
    /**
     * Función que devuleve la suma de una columna especificada como parámetro
     * @param  string $campo que se desea sumar
     * @return integer resultado de la suma
     */
    public function sum_col($campo = '')
    {
        if (isset($campo)) {
            $this->orden_l[] = "SELECT sum($campo) as total_col";
            return $this;
        } else {
            throw new Exception(mostrar_error('Modelo', 'Se requiere del nombre de la columna a sumar, indíquelo.'));
        }
    }

    /**
     * Función segmentada de selección de campos,
     * esta función debe ser precedida de otras funciones
     * como ser: $this->desde() y $this->obtener() para recibir los registros
     * seleccionados.
     *
     * Ej:
     * $tabla = $this->seleccionar(array('usuario','password'))->desde('usuarios')->obtener();
     * Esta devolveria todos los registros con los campos usuario y password desde
     * la tabla usuarios
     *
     * Obs:
     * Esta función permite anidamientos con otras funciones
     *
     * @param  mixed  $campos String o array de los nombres de campos
     *
     * @return object         Se devuelve asi mismo
     */
    public function seleccionar($campos = array())
    {
        $this->orden_l = array();
        if (is_array($campos)) {
            if (count($campos) > 0) {
                $this->orden_l[] = 'select '.implode(', ', $campos);
            } else {
                $this->orden_l[] = 'select *';
            }
        } else {
            if (!empty($campos)) {
                $this->orden_l[] = 'select '.$campos;
            } else {
                $this->orden_l[] = 'select *';
            }
        }

        return $this;
    }

    public function desde($tabla = '')
    {
        if (!empty($tabla)) {
            $this->orden_l[] = 'from '.$tabla;
        } else {
            $this->orden_l[] = 'from '.$this->tabla;
        }

        return $this;
    }

    public function unir($tabla = '', $mientras = '', $tipo = 'INNER')
    {
        if (count($this->orden_l) <= 0) {
            $this->seleccionar()->desde();
        }
        $sql = "$tipo JOIN $tabla ON $mientras ";
        $this->orden_l[] = $sql;

        return $this;
    }

    public function mientras($condicion = array())
    {
        if (is_array($condicion)) {
            if (count($condicion) > 0) {
                $aux = 'WHERE ';
                foreach ($condicion as $value) {
                    $aux .= "$value AND ";
                }
                $aux = preg_replace('/AND $/', '', $aux);
                $this->orden_l[] = $aux;
            }
        } else {
            if (!empty($condicion)) {
                $this->orden_l[] = "WHERE $condicion";
            }
        }

        return $this;
    }

    public function ordenar($columna = '', $orden = 'ASC')
    {
        if (is_array($columna)) {
            if (count($columna) > 0) {
                $aux = '';
                foreach ($columna as $col => $ord) {
                    $aux .= " ORDER BY $col $ord AND ";
                }
                $aux = preg_replace('/AND $/', '', $aux);
                $this->orden_l[] = $aux;
            }
        } else {
            $this->orden_l[] = " ORDER BY $columna $orden";
        }

        return $this;
    }

    public function limite($segmento = 0, $limite = 0)
    {
        if ($segmento == 0 && $limite == 0) {
            $limite = '';
        } else {
            $limite = '';
            switch ($this->tipo) {
                case 'mysql':
                    $limite = ' LIMIT '.$segmento.', '.$limite;
                    break;
                case 'pgsql':
                    $limite = ' LIMIT '.$limite.' OFFSET '.$segmento;
                    break;
                case 'firebird':
                    //$limite = ' LIMIT '.$limite.' OFFSET '.$segmento;
                    $this->orden = str_replace('SELECT', 'SELECT First '.$limite, $this->orden);
                    break;
                default:
                    $limite = ' LIMIT '.$segmento.', '.$limite;
                    break;
            }
        }
        $this->orden_l[] = $limite;

        return $this;
    }

    /**
     * Función segmentada, se ejecuta depués de preparar
     * las consultas o ejecutar directo para recuperar todos los registros
     * Uso
     * $this->seleccionar()->desde()->obtener.
     *
     * @param  bool $objeto True para obtener objeto, false
     *                         para obtener array
     * @param  bool $lista  True para obtener en forma de lista
     *                         false para obener en caso de un registro
     *                         un solo arreglo asociativo
     *                         Colocar True si se espera los resultados
     *                         como para recorrerlo
     *
     * @return mixed           Objeto u array asociativo, según el parámetro
     *                         anterior
     */
    public function obtener($objeto = true, $lista = true)
    {
        if (count($this->orden_l) <= 0) {
            $this->seleccionar()->desde();
        }
        $orden = implode(' ', $this->orden_l);
        $resul = $this->ejecutar($orden, $objeto);
        if ($lista) {
            return $resul;
        } else {
            return ($this->obt_cant_filas() == 1) ? $resul[0] : $resul;
        }
    }

    public function obtener_mientras($condicion = '', $objeto = true)
    {
        //$this->orden_l = array();
        if (count($this->orden_l) <= 0) {
            $this->seleccionar()->desde();
        }
        $this->mientras($condicion);

        return $this->obtener($objeto);
    }
    public function guardar_simulado()
    {
        $campo_primario = $this->obt_cam_primario();
        $clave = array($campo_primario => $this->obt_ult_id());
        $sql = false;
        // si existe un campo primario
        if (array_key_exists($campo_primario, $this->datos)) {
            $id = $this->datos[$campo_primario];
            unset($this->datos[$campo_primario]);
            // preguntamos, si es cero (nuevo) será insertado un nuevo registro
            if ($id == 0) {
                $sql = $this->armar_sql_insert($this->datos);
            } else {
                // o será editado
                $clave = array($campo_primario => $id);
                $sql = $this->armar_sql_editar($this->datos, $clave);
            }
        } else {
            //será insertado un nuevo registro
            $sql = $this->armar_sql_insert($this->datos);
        }

        return $sql;
    }
    public function guardar($devolver = true)
    {
        $campo_primario = $this->obt_cam_primario();
        $result = false;
        $id = 0;
        // si existe un campo primario
        if (array_key_exists($campo_primario, $this->datos)) {
            $id = $this->datos[$campo_primario];
            unset($this->datos[$campo_primario]);
            // preguntamos, si es cero (nuevo) será insertado un nuevo registro
            if ($id == 0) {
                $result = $this->insertar($this->datos);
            } else {
                // o será editado
                $mientras = array($campo_primario => $id);
                $result = $this->editar($this->datos, $mientras);
            }
        } else {
            //será insertado un nuevo registro
            $result = $this->insertar($this->datos);
        }
        if ($result) {
            // Al guardar con éste método, se obtiene éste registro si es que devolver está en true
            if ($devolver) {
                $id = ($id == 0) ? $this->obt_ult_id() : $id;
                $result = $this->buscar_por(array($campo_primario => $id));
            }
        }
        return $result;
    }

    public function eliminar_por($datos = array())
    {
        $mientras = '';
        foreach ($datos as $campo => $valor) {
            switch (tipo_var($valor)) {
                case 'string':
                    $mientras .= (empty($mientras)) ? "$campo = '$valor'" : "$campo = '$valor' AND ";
                    break;

                case 'integer':
                    $mientras .= (empty($mientras)) ? "$campo = $valor" : "$campo = $valor AND ";
                    break;

                case 'numeric':
                    $mientras .= (empty($mientras)) ? "$campo = $valor" : "$campo = $valor AND ";
                    break;

                case 'float':
                    $mientras .= (empty($mientras)) ? "$campo = $valor" : "$campo = $valor AND ";
                    break;

                default:
                    $mientras .= (empty($mientras)) ? "$campo = '$valor'" : "$campo = '$valor' AND ";
                    break;
            }
        }
        $orden = 'DELETE FROM '.$this->tabla.' WHERE ';
        $this->orden = $orden . $mientras;
        $cantidad = $this->exec($this->orden);
        $this->cant_filas = $cantidad;

        return $this->cant_filas;
    }

    public function obt_tablas($obt = true)
    {
        $this->orden = 'SHOW TABLES';
        $resultados = $this->query($this->orden);
        $this->tablas = ($obt) ? $resultados->fetchall(PDO::FETCH_OBJ) : $resultados->fetchall();

        return $this->tablas;
    }
    public function insertar_obtener($datos = array(), $simular = false)
    {
        $result = $this->insertar($datos, $simular);
        if (!$simular) {
            if ($result) {
                $result = $this->buscar_por(array($this->obt_cam_primario() => $this->obt_ult_id()));
            }
        }
        return $result;
    }
    public function insertar($datos = array(), $simular = false)
    {
        return $this->bd_interface->insertar($datos, $simular);
    }
    public function editar($datos = array(), $clave = array(), $simular = false)
    {
        return $this->bd_interface->editar($datos, $clave, $simular);
    }
    public function ejecutar($orden = '', $objeto = false)
    {
        return $this->bd_interface->ejecutar($orden, $objeto);
    }
    public function comprobar($resultado)
    {
        if ($resultado) {
            return true;
        } else {
            if (isset($this->config->error)) {
                if ($this->config->error) {
                    exit(mostrar_error('Modelo', 'Error: '.$this->obt_error()));
                } else {
                    return false;
                }
            } else {
                exit(mostrar_error('Modelo', 'Error: '.$this->obt_error()));
            }
        }
    }

    private function obt_tipo($value)
    {
        return tipo_var($value);
    }

    public function obt_sum_col($columna = '')
    {
        return $this->sum_col($columna)->desde()->obtener(true, false)->total_col;
    }

    public function obt_descripcion()
    {
        $libreria = 'sistema\librerias\estructura_bd';
        $estructura = obt_coleccion($libreria)::obt_instancia();
        $datos = $estructura->obtener($this->tabla);

        if (count($datos) <= 0) {
            $datos = $this->bd_interface->describir_tabla($this->tabla);
            $estructura->escribir($datos, $this->tabla);
            $datos = $estructura->obtener($this->tabla);
        }

        return $datos;
    }

    public function obt_campos()
    {
        $datos = $this->obt_descripcion();
        $campos = array();
        foreach ($datos as $key => $value) {
            array_push($campos, $key);
        }
        $this->campos = $campos;
        return $this->campos;

        // $this->campos = $this->bd_interface->obt_campos();
        // return $this->campos;
    }

    public function obt_cam_primario()
    {
        if (empty($this->cam_primario)) {
            $campos = $this->obt_campos();
            $this->cam_primario = $campos[0];
        }
        return $this->cam_primario;
    }
    public function obt_modelo_vacio()
    {
        $result = $this->obt_descripcion();

        $array = array();

        foreach ($result as $key => $value) {
            $valor = '';
            switch (trim($value)) {
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
            $array[$key] = $valor;
        }
        return $array;
        // $this->campos = $this->bd_interface->obt_modelo_vacio();
        // return $this->campos;
    }
    /**
     * Devuelve la cantidad de registros de forma general
     * o según las candiciones pasada como parámetro.
     *
     * @param  string $mientras Condición por las que se contarán los registros
     *                          ejemplo: "idcategoria=1452" devolverá la cantidad
     *                          de registros con el idcategoria 1452
     *
     * @return int           Cantidad de registros
     */
    public function obt_cant_gral($mientras = '')
    {
        if (is_array($mientras)) {
            if (count($mientras) > 0) {
                $orden = 'SELECT COUNT(*) as CANT FROM '.$this->tabla.' WHERE ';
                foreach ($mientras as $campo => $valor) {
                    $orden .= $campo.'=:'.$campo.', ';
                }
                $orden = preg_replace('/, $/', '', $orden);
                $this->orden = $orden;
                // se prepara la plantilla
                $sentencia = $this->prepare($this->orden);
                // se arma la fila con los datos ingresados
                $fila = array();
                foreach ($mientras as $campo => $valor) {
                    $fila[':'.$campo] = $valor;
                }
                // se ejecuta
                $sentencia->execute($fila);
                $resultados = $sentencia->fetchall(PDO::FETCH_ASSOC);
                if (count($resultados)>0) {
                    return $resultados[0]['CANT'];
                } else {
                    return 0;
                }
            }
        } else {
            if (empty($mientras)) {
                $this->orden = 'SELECT COUNT(*) as CANT FROM '.$this->tabla;
            } else {
                $this->orden = 'SELECT COUNT(*) as CANT FROM '.$this->tabla.' WHERE '.$mientras;
            }
            // se ejecuta
            $resultados = $this->ejecutar($this->orden);
            if (count($resultados)>0) {
                return $resultados[0]['CANT'];
            } else {
                return 0;
            }
        }
    }
    public function consistencia($datos=array())
    {
        $obt_nulo = function ($campo, $detalle) {
            $t = '';
            foreach ($detalle as $key => $value) {
                if (trim($campo) == trim($value['FIELD_NAME'])) {
                    $t = $value['FIELD_NULL'];
                    break;
                }
            }
            return $t;
        };
        $obt_tipo = function ($campo, $detalle) {
            $t = '';
            foreach ($detalle as $key => $value) {
                if (trim($campo) == trim($value['FIELD_NAME'])) {
                    $t = $value['FIELD_TYPE'];
                    break;
                }
            }
            return $t;
        };
        $s = '';

        $detalle = $this->obt_descripcion();

        foreach ($datos as $key => $value) {
            $tipo = $obt_tipo($key, $detalle);
            $nulo = $obt_nulo($key, $detalle);
            $s .= "$key: $value tipo: $tipo nulo: $nulo, \n";
        }
        return $s;
    }
    public function obt_lista($offset = 0, $limite = 0)
    {
        $this->orden_l = array();

        $this->seleccionar();

        $this->desde();

        $this->limite($offset, $limite);

        $result = $this->obtener();

        return $result;
    }

    public function obt_cant_filas()
    {
        return $this->cant_filas;
    }

    public function obt_ult_id($secuencia = '')
    {
        $this->ultimo_id = $this->bd_interface->obt_ult_id($secuencia);
        return $this->ultimo_id;
    }

    public function obt_tabla()
    {
        return $this->tabla;
    }

    public function obt_error()
    {
        return implode(',', $this->errorInfo());
    }
    public function obt_orden()
    {
        return $this->orden;
    }
    public function obt_orden_l()
    {
        return implode(' ', $this->orden_l);
    }
    public function obt_datos()
    {
        return $this->datos;
    }
    public function env_datos($datos=array(), $filtrado=true)
    {
        if (is_array($datos)) {
            if (count($datos)>0) {
                $campos = $this->obt_campos();
                $this->datos =  ($filtrado) ? obt_arreglo($campos, $datos) : $datos;
            }
        }
    }
    public function env_orden($orden = '')
    {
        if (!empty($orden)) {
            $this->orden = $orden;
        }
    }
    public function obt_config()
    {
        return $this->config;
    }
    public function obt_orden_hist()
    {
        return $this->orden_hist;
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

/* Fin de archivo PK_Modelo.php */
/* Ubicacion: sistema/nucleo/PK_Modelo.php */
