<?php

namespace sistema\nucleo;

use \PDO;

if (!defined('SISTEMA')) {
    exit('No se permite acceso directo al script');
}

/**
 *
 * Modelo Principal del Sistema
 * De ésta debe extenderse los modelos del usuario,
 * de esa forma tendrá heredadas todos los métodos o funciones
 * que contienen ésta clase
 *
 * CONFIGURACION
 *
 * Configurar la Base de Datos en aplicacion/configuracion/bd.php
 *
 * ATENCION
 * No tocar las propiedades de ésta clase
 * Si desea configurar su Base de Datos, hacer lo indicado anteriormente
 *
 * @package sistema
 * @subpackage nucleo
 * @copyright Ricksystems (c)2014
 * @author Ricardo Rotela <ricksystems@gmail.com>
 * @version 1.0 2014/08/30
 */
class PK_Modelo extends PDO {

    /**
     * Contenedor del Nombre del Host
     * @var string
     */
    private $host_bd = '';

    /**
     * Contenedor del Puerto del Host
     * @var integer
     */
    private $port_bd = 0;

    /**
     * Contenedor del Tipo de base de datos
     * @var string
     */
    private $tipo_bd = '';

    /**
     * Contenedor del Nombre de Usuario / User de la BD
     * @var string
     */
    private $user_bd = '';

    /**
     * Contenedor del Password del Usuario / User de la bd
     * @var string
     */
    private $pass_bd = '';

    /**
     * Contenedor del Nombre de La Base de Datos a utilizar
     * @var string
     */
    private $base_bd = '';

    /**
     * Contenedor del Tipo de Cotejamiento que utilizará el Modelo
     * @var string
     */
    private $cote_bd = 'utf8';

    /**
     * Contenedor del Nombre de la tabla con la cual construír
     * el Modelo
     * @var string
     */
    private $tabla = '';

    /**
     * Contenedor de Nombres de las Tablas contenidas en la bd
     * @var array
     */
    private $tablas = array();

    /**
     * Contenedor de los Nombre de Columnas
     * @var array
     */
    private $campos = array();

    /**
     * Cantidad de filas dovolvidas por alguna consulta
     * @var integer
     */
    private $cant_filas = 0;

    /**
     * Ultimo id del registro que se haya insertado (sólo mysql)
     * @var integer
     */
    private $ultimo_id = 0;

    /**
     * Contenedor de datos de registro generados por alguna consulta
     * dependiendo si es un arreglo tipo array u objeto
     * @var array
     */
    public $datos = array();

    /**
     * Contenedor de la última sentencia SQL ejecutada
     * @var string
     */
    private $orden = '';

    /**
     * Contenedor de sentencias SQL de forma de array, segmentadas
     * @var array
     */
    private $orden_l = array();

    /**
     * Contenedor de todas las órdenes SQL ejecutadas en una instancia
     * @var array
     */
    private $orden_hist = array();

    /**
     * Contenedor del error/es
     * @var string
     */
    private $error = '';

    /**
     * Contiene todas las columnas de una fila
     * @var array
     */
    public $fila = array();

    /**
     * Propiedad protegida para las instanciaciones
     * @var [type]
     */
    protected $tg;

    /**
     * Se utiliza Singleton para instanciar fuera del controlador
     */
    use PK_Singleton;

    /**
     * Marcador para saber si está conectado
     */
    private $conectado = false;

    /**
     * El contructor requiere o espera el nombre de la tabla a utilizar
     * por el modelo, se debe indicar el nombre de la tabla
     * en el constructor del modelo hijo o clase hija
     * @param string $tabla [description]
     */
    public function __construct($tabla = '') {
        if (empty($tabla)) {
            throw new \Exception(mostrar_error('Modelo', 'Se requiere del nombre de la tabla a utilizar por éste modelo.'));
        } else {
            $this->tabla = trim($tabla);
        }
    }

    /**
     * Configura y conecta el modelo con la BD, según
     * los datos suministrados en aplicacion/configuracion/bd.php
     */
    private function conectar() {
        // obtengo la configuración desde la configuración de bd
        $config = PK_Config::obt_instancia()->obtener('bd');
        // configuro con los datos obtenidos
        $this->host_bd = $config->host_bd;    //servidor de la base datos
        $this->port_bd = $config->port_bd;    //puerto de la base de datos
        $this->tipo_bd = $config->tipo_bd;    //tipo de base de datos
        $this->user_bd = $config->user_bd;    //usuario de la base de datos
        $this->pass_bd = $config->pass_bd;    //password de la base de datos
        $this->base_bd = $config->base_bd;    //base de datos a utilizar
        $this->cote_bd = $config->cote_bd;    //cotejamiento
        // según el tipo de base de datos, lo conecto,
        // por el momento se tiene preparado a mysql, pgsql, puedes extender a otros
        // tipos de base de datos, si sabes como se conecta
        try {
            switch ($this->tipo_bd) {
                case 'mysql':
                    parent::__construct('mysql:host=' . $this->host_bd . ';dbname=' . $this->base_bd, $this->user_bd, $this->pass_bd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->cote_bd));
                    break;

                case 'pgsql';
                    parent::__construct('pgsql:dbname=' . $this->base_bd . ';host=' . $this->host_bd, $this->user_bd, $this->pass_bd);
                    break;

                case "firebird";
                    $server = "firebird:dbname=". $this->host_bd . '/'.$this->port_bd.":".$this->base_bd;
                    //"firebird:dbname=192.168.2.110/3050:/db/BDFINANSYS.fdb"
                    //echo $server;
                    //exit();
                    parent::__construct($server, $this->user_bd, $this->pass_bd);
                    break;

                default:
                    parent::__construct('mysql:host=' . $this->host_bd . ';dbname=' . $this->base_bd, $this->user_bd, $this->pass_bd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->cote_bd));
                    break;
            }
            $this->conectado = true;
        } catch (\PDOException $e) {
            exit(mostrar_error('Modelo', utf8_encode($e->getMessage())));
        }
    }

    /**
     * Se utiliza para asignar a un valor a un campo
     * como si fuera una funcion, ej.
     * $this->edad(30)
     * Esta función es utilizada con la función guardar()
     * @param  string $nombre    Nombre de la función (nombre del campo o columna)
     * @param  mixed $parametro Parámetro de la función
     */
    public function __call($nombre = '', $parametro) {
        if (empty($this->campos)) {
            $this->obt_campos();
        }
        if (in_array($nombre, $this->campos)) {
            $this->datos[$nombre] = $parametro[0];
        } else {
            throw new \Exception(mostrar_error('Modelo', "Función <strong>'$nombre'</strong></strong> desconocida o no existe el campo <strong>'$nombre'</strong>"));
        }
    }

    /**
     * Función para obtener datos de una columna específica
     * Ej.
     * echo $this->edad
     * Esta función es utilizada despues de ejecutar una búsqueda
     * o consulta que devuelva un sólo registro.
     * @param  [type] $propiedad Nombre de la propiedad a acceder
     *                           Nombre de la columna a acceder
     * @return mixed            Según lo que contiene ésa propiedad o columna
     */
    public function __get($propiedad) {
        if (array_key_exists($propiedad, $this->fila)) {
            return $this->fila[$propiedad];
        } else {
            return '';
        }
    }

    /**
     * Devuelve la fila del registro encontrado, y sus columnas como propiedades
     * Esta función es utilizada después de una búsqueda o consulta
     * anterior
     * @return object Objecto de la fila encontrada
     */
    public function obt_fila() {
        return $this->fila;
    }

    /**
     * Busca un registro con los datos pasados como parámetros,
     * Esta función es ideal para encontrar registros únicos o específicos
     * No se recomienda utilizar si se espera varios registros
     * @param  array   $datos  Parámetro de búsqueda ej.
     *                         $this->buscar_por(array('id'=>8));
     *                         Lo anterior buscará el registro con la columna
     *                         id = 8
     * @param boolean          Se indica false si desea el resultado como array
     *                         asociativo o true en caso de objeto
     * @return  mixed $objeto  Devuelve el resultado o false si no encontró
     */
    public function buscar_por($datos = array(), $objeto = TRUE, $columnas = array()) {
        $this->comprobar_conexion();
        // preparo la orden
        if (count($columnas) == 0) {
            $orden = 'SELECT * FROM ' . $this->tabla . ' WHERE ';
        } else {
            $orden = 'SELECT ' . implode(', ', $columnas) . ' FROM ' . $this->tabla . ' WHERE ';
        }
        foreach ($datos as $campos => $valor) {
            $orden .= $campos . " = :" . $campos . " AND ";
        }
        $this->orden = preg_replace('/AND $/', '', $orden);
        $query = $this->prepare($this->orden);
        // paso los parámetros
        foreach ($datos as $campo => $valor) {
            $query->bindValue(':' . $campo, $valor);
        }
        // ejecuto
        $resultados = $query->execute();
        // compruebo los resultados
        if ($this->comprobar($resultados)) {
            $cant = $query->rowCount();
            $this->cant_filas = empty($cant) ? 0 : $cant;
            if ($this->cant_filas > 0) {
                $fila = $query->fetchAll(PDO::FETCH_ASSOC);
                $this->fila = $fila[0];
                if ($objeto) {
                    return (object) $fila[0];
                } else {
                    return $fila[0];
                }
            } else {
                return FALSE;
            }
        }
    }

    public function sum_col($campos = '') {
        if (isset($campos)) {
            $this->orden_l[] = 'SELECT sum(' . $campos . ') as total_col';
            return $this;
        } else {
            throw new \Exception(mostrar_error('Modelo', 'Se requiere del nombre de la columna a sumar, indíquelo.'));
        }
    }

    /**
     * Función segmentada de selección de campos,
     * esta función debe ser precedida de otras funciones
     * como ser: $this->desde() y $this->obtener() para recibir los registros
     * seleccionados
     *
     * Ej:
     * $tabla = $this->seleccionar(array('usuario','password'))->desde('usuarios')->obtener();
     * Esta devolveria todos los registros con los campos usuario y password desde
     * la tabla usuarios
     *
     * Obs:
     * Esta función permite anidamientos con otras funciones
     * @param  mixed  $campos String o array de los nombres de campos
     * @return object         Se devuelve asi mismo
     */
    public function seleccionar($campos = array()) {
        if (is_array($campos)) {
            if (count($campos) > 0) {
                $this->orden_l[] = 'SELECT ' . implode(', ', $campos);
            } else {
                $this->orden_l[] = 'SELECT *';
            }
        } else {
            if (!empty($campos)) {
                $this->orden_l[] = 'SELECT ' . $campos;
            } else {
                $this->orden_l[] = 'SELECT *';
            }
        }
        return $this;
    }

    public function desde($tabla = '') {
        if (!empty($tabla)) {
            $this->orden_l[] = 'FROM ' . $tabla;
        } else {
            $this->orden_l[] = 'FROM ' . $this->tabla;
        }
        return $this;
    }

    public function unir($tabla = '', $mientras = '', $tipo = 'INNER') {
        $sql = "$tipo JOIN $tabla ON $mientras";
        $this->orden_l[] = $sql;
        return $this;
    }

    public function mientras($condicion = array()) {
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

    public function ordenar($columna = '', $orden = 'ASC') {
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

    public function limite($segmento = 0, $limite = 0) {
        if ($segmento == 0 && $limite == 0) {
            $limite = '';
        } else {
            switch ($this->tipo_bd) {
                case 'mysql':
                    $limite = ' LIMIT ' . $segmento . ', ' . $limite;
                    break;
                case 'pgsql':
                    $limite = ' LIMIT ' . $limite . ' OFFSET ' . $segmento;
                    break;
                case 'firebird':
                    $limite = ' LIMIT ' . $limite . ' OFFSET ' . $segmento;
                    break;
                default:
                    $limite = ' LIMIT ' . $segmento . ', ' . $limite;
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
     * $this->seleccionar()->desde()->obtener
     * @param  boolean $objeto True para obtener objeto, false
     *                         para obtener array
     * @param  boolean $lista  True para obtener en forma de lista
     *                         false para obener en caso de un registro
     *                         un solo arreglo asociativo
     *                         Colocar True si se espera los resultados
     *                         como para recorrerlo
     * @return mixed           Objeto u array asociativo, según el parámetro
     *                         anterior
     */
    public function obtener($objeto = TRUE, $lista = TRUE) {
        $this->comprobar_conexion();
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

    public function obtener_mientras($condicion = '', $objeto = TRUE) {
        if (count($this->orden_l <= 0)) {
            $this->seleccionar()->desde();
        }
        $this->mientras($condicion);
        return $this->obtener($objeto);
    }

    public function guardar() {
        $this->comprobar_conexion();
        // si existe un campo primario, será editado (modificado), o
        if (array_key_exists($this->obt_cam_pri(), $this->datos)) {
            $nom_cla = $this->obt_cam_pri();
            $clave = array($nom_cla => $this->datos[$nom_cla]);
            unset($this->datos[$nom_cla]);
            $estado = $this->editar($this->datos, $clave);
        } else {
            //será insertado un nuevo registro
            $estado = $this->insertar($this->datos);
            $clave = array($this->obt_cam_pri() => $this->obt_ult_id());
        }
        // Al guardar con éste método, se obtiene instantáneamente
        // el registro guardado (el último).
        $this->buscar_por($clave);
        return $estado;
    }

    public function eliminar_por($datos = array()) {
        $this->comprobar_conexion();
        $orden = 'DELETE FROM ' . $this->tabla . ' WHERE ';
        foreach ($datos as $campo => $valor) {
            $orden .= $campo . " = '" . $valor . "' AND ";
        }
        $orden = preg_replace('/AND $/', '', $orden);
        $this->orden = $orden;
        $cantidad = $this->exec($this->orden);
        $this->cant_filas = $cantidad;
        return $this->cant_filas;
    }

    public function obt_tablas() {
        $this->comprobar_conexion();
        $this->orden = 'SHOW TABLES';
        $resultados = $this->query($this->orden);
        $this->tablas = $resultados->fetchall(PDO::FETCH_OBJ);
        return $this->tablas;
    }

    public function insertar($datos = array(),$simular=false) {
        $this->comprobar_conexion();
        // se arma la plantilla
        $orden = 'INSERT INTO ' . $this->tabla . ' (';
        foreach ($datos as $campo => $valor) {
            $orden .= $campo . ', ';
        }
        $orden .= ') VALUES (';
        foreach ($datos as $campo => $valor) {
            $orden .= ':' . $campo . ', ';
        }
        $orden .= ')';
        // se limpia
        $this->orden = str_replace(', )', ')', $orden);

        $this->orden_hist[] = $this->orden;

        // se prepara la plantilla
        $sentencia = $this->prepare($this->orden);
        // se arma la fila con los datos ingresados
        $fila = array();
        foreach ($datos as $campo => $valor) {
            $fila[':' . $campo] = $valor;
        }
        // se ejecuta
        $estado = $sentencia->execute($fila);
        if ($simular) {
            echo $this->orden;
            exit();
        }else{
            if ($this->comprobar($estado)) {
                $this->ultimo_id = $this->lastInsertId();
                return $estado;
            }
        }
    }

    public function editar($datos = array(), $clave = array()) {
        $this->comprobar_conexion();
        // se arma la plantilla
        $orden = 'UPDATE ' . $this->tabla . ' SET ';
        foreach ($datos as $campo => $valor) {
            $orden .= $campo . '=:' . $campo . ', ';
        }
        $orden .= 'WHERE ';
        foreach ($clave as $key => $value) {
            $orden .= $key . '=' . $value . ' AND ';
        }
        $orden = preg_replace('/AND $/', '', $orden);
        $orden = str_replace(', WHERE', ' WHERE', $orden);
        $this->orden = $orden;

        // se prepara la plantilla
        $sentencia = $this->prepare($this->orden);
        // se arma la fila con los datos ingresados
        $fila = array();
        foreach ($datos as $campo => $valor) {
            $fila[':' . $campo] = $valor;
        }
        // se ejecuta
        $estado = $sentencia->execute($fila);
        if ($this->comprobar($estado)) {
            return $estado;
        }
    }

    public function ejecutar($orden = '', $objeto = TRUE) {
        $this->comprobar_conexion();
        $this->orden = $orden;
        $this->orden_hist[] = $this->orden;
        $resultado = $this->query($this->orden);
        if ($this->comprobar($resultado)) {
            $this->cant_filas = $resultado->rowCount();
            if ($objeto) {
                return $resultado->fetchall(PDO::FETCH_OBJ);
            } else {
                return $resultado->fetchall(PDO::FETCH_ASSOC);
            }
        }
    }

    private function comprobar($resultado) {
        if ($resultado) {
            return TRUE;
        } else {
            exit(mostrar_error('Modelo', 'Error: ' . $this->obt_error()));
        }
    }

    private function obt_tipo($value = '') {
        $arreglo = explode('(', $value);
        switch ($arreglo[0]) {
            case 'init':
                return 0;
                break;
            case 'tinyint':
                return 0;
                break;
            default:
                return '';
                break;
        }
    }

    public function obt_sum_col($columna = '') {
        return $this->sum_col($columna)->desde()->obtener(true, false)->total_col;
    }

    public function obt_campos() {
        $this->comprobar_conexion();
        if ($this->tipo_bd == 'firebird') {
            $resultado = $this->query('SELECT FIRST 1 * FROM ' . $this->tabla);
        }else{
            $resultado = $this->query('SELECT * FROM ' . $this->tabla . ' LIMIT 1');
        }
        $datos = array();
        for ($c = 0; $c <= $resultado->columnCount(); $c++) {
            $meta = $resultado->getColumnMeta($c);
            if (!empty($meta['name'])) {
                $this->campos[] = $meta['name'];
                $datos[] = $meta;
            }
        }
        return $datos;
    }

    public function obt_cam_pri() {
        return $this->campos[0];
    }
    /**
     * Devuelve la cantidad de registristros de forma general
     * o según las candiciones pasada como parámetro
     * @param  string $mientras Condición por las que se contarán los registros
     *                          ejemplo: "idcategoria=1452" devolverá la cantidad
     *                          de registros con el idcategoria 1452
     * @return int           Cantidad de registros
     */
    public function obt_cant_gral($mientras = '') {
        $this->comprobar_conexion();
        if (is_array($mientras)) {
            if (count($mientras) > 0) {
                $orden = 'SELECT COUNT(*) as cant FROM ' . $this->tabla . ' WHERE ';
                foreach ($mientras as $campo => $valor) {
                    $orden .= $campo . '=:' . $campo . ', ';
                }
                $orden = preg_replace('/, $/', '', $orden);
                $orden.= ' LIMIT 1';
                $this->orden = $orden;
                // se prepara la plantilla
                $sentencia = $this->prepare($this->orden);
                // se arma la fila con los datos ingresados
                $fila = array();
                foreach ($mientras as $campo => $valor) {
                    $fila[':' . $campo] = $valor;
                }
                // se ejecuta
                $estado = $sentencia->execute($fila);
                if ($this->comprobar($estado)) {
                    $resultados = $sentencia->fetchall(PDO::FETCH_OBJ);
                    $fila = $resultados[0];
                    return $fila->cant;
                }
            }
        } else {
            if (empty($mientras)) {
                $this->orden = 'SELECT COUNT(*) as cant FROM ' . $this->tabla . ' LIMIT 1';
                $resultados = $this->ejecutar($this->orden);
            } else {
                $this->orden = 'SELECT COUNT(*) as cant FROM ' . $this->tabla . ' WHERE ' . $mientras . ' LIMIT 1';
                $resultados = $this->ejecutar($this->orden);
            }
            $fila = $resultados;
            return $fila[0]->cant;
        }
    }
    public function obt_lista($offset=0,$limite=0)
    {
        return $this->seleccionar()->desde()->limite($offset,$limite)->obtener();
    }
    public function obt_cant_filas() {
        return $this->cant_filas;
    }

    public function obt_ult_id($secuencia = '') {
        if ($this->tipo_bd == 'pgsql') {
            $this->ultimo_id = $this->lastInsertId($secuencia);
        }
        return $this->ultimo_id;
    }

    public function obt_error() {
        if (count($this->error)>0) {
            $this->error = implode(",", $this->errorInfo());
        }else{
            $this->error = "Al parecer no hay errores";
        }
        return $this->error;
    }

    public function obt_orden() {
        return $this->orden;
    }

    public function obt_orden_l() {
        return implode(" ", $this->orden_l);
    }

    public function obt_datos_combo($campos = array()) {
        return $this->seleccionar($campos)->desde()->obtener(FALSE);
    }

    public function obt_orden_hist() {
        return $this->orden_hist;
    }

    private function comprobar_conexion() {
        if (!$this->conectado)
            $this->conectar();
    }

}

/* Fin de archivo PK_Modelo.php */
/* Ubicacion: sistema/nucleo/PK_Modelo.php */