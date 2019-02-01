<?php
namespace sistema\nucleo;

use \PDO;
use \PDOException;
use \Exception;

use sistema\modelos\mysql_bd;
use sistema\modelos\sqlite_bd;
use sistema\modelos\pgsql_bd;
use sistema\modelos\firebird_bd;

if (!defined('SISTEMA')) {
    exit('No se permite acceso directo al script');
}

/**
 * Conexion a base de datos principal del Sistema
 * De ésta se extiendo el PK_Modelo,
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
 * @copyright Rotelabs (c)2018
 * @author Ricardo Rotela <rotelabs->gmail.com>
 *
 * @version 1.0 2018/09/14
 */
class PK_Conexion extends PDO
{
    /**
   * Contenedor del Nombre del Host.
   *
   * @var string
   */
    private $host = '';

    /**
     * Contenedor del Puerto del Host.
     *
     * @var int
     */
    private $port = 0;

    /**
     * Contenedor del Tipo de base de datos.
     *
     * @var string
     */
    private $tipo = '';

    /**
     * Contenedor del Nombre de Usuario / User de la BD.
     *
     * @var string
     */
    private $user = '';

    /**
     * Contenedor del Password del Usuario / User de la bd.
     *
     * @var string
     */
    private $pass = '';

    /**
     * Contenedor del Nombre de La Base de Datos a utilizar.
     *
     * @var string
     */
    private $base = '';

    /**
     * Contenedor del Tipo de Cotejamiento que utilizará el Modelo.
     *
     * @var string
     */
    private $cote = 'utf8';

    /**
     * Propiedad protegida para las configuraciones.
     *
     * @var [array]
     */
    protected $config;

    /**
    * instancia de referencia de las interfaces
    */
    private $bd_interface;

    /*
    * Se utiliza Singleton para instanciar fuera del controlador
    */
    use PK_Singleton;

    public function __construct($config = array())
    {
        // obtengo la configuración desde la configuración de bd y modelo
        if (is_array($config)) {
            $config = (count($config)>0) ? $config : objeto_array(PK_Config::obt_instancia()->obtener('bd'));
        } else {
            $config = objeto_array(PK_Config::obt_instancia()->obtener($config));
        }

        $modelo = objeto_array(PK_Config::obt_instancia()->obtener('modelo'));
        $this->config = array_objeto(array_merge($config, $modelo));
        // configuro con los datos obtenidos
        $this->host = $this->config->host;    //servidor de la base datos
        $this->port = $this->config->port;    //puerto de la base de datos
        $this->tipo = $this->config->tipo;    //tipo de base de datos
        $this->user = $this->config->user;    //usuario de la base de datos
        $this->pass = $this->config->pass;    //password de la base de datos
        $this->base = $this->config->base;    //base de datos a utilizar
        $this->cote = $this->config->cote;    //cotejamiento
        // según el tipo de base de datos, lo conecto,
        // por el momento se tiene preparado a mysql, pgsql, puedes extender a otros
        // tipos de base de datos, si sabes como se conecta

        try {
            switch ($this->tipo) {
                case 'sqlite':
                    parent::__construct('sqlite:'.$this->base);
                   $this->bd_interface = new sqlite_bd($this);
                    break;

                case 'mysql':
                    parent::__construct('mysql:host='.$this->host.';dbname='.$this->base, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$this->cote));
                    $this->bd_interface = new mysql_bd($this);
                    break;

                case 'pgsql':
                    parent::__construct('pgsql:dbname='.$this->base.';host='.$this->host, $this->user, $this->pass);
                    $this->bd_interface = new pgsql_bd($this);
                    break;

                case 'firebird':
                    $server = 'firebird:dbname='.$this->host.'/'.$this->port.':'.$this->base;
                    parent::__construct($server, $this->user, $this->pass);
                    $this->bd_interface = new firebird_bd($this);
                    break;

                default:
                    parent::__construct('mysql:host='.$this->host.';dbname='.$this->base, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$this->cote));
                    $this->bd_interface = new mysql_bd($this);
                    break;
            }
            // $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->devolver_error($e);
        } catch (Exception $e) {
            $this->devolver_error($e);
        }
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
    public function obt_error()
    {
        return implode(',', $this->errorInfo());
    }
    public function obt_config()
    {
        return $this->config;
    }
    public function obt_interface()
    {
        return $this->bd_interface;
    }
}

/* Fin de archivo PK_Conexion.php */
/* Ubicacion: sistema/nucleo/PK_Conexion.php */
