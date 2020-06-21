<?php

namespace sistema\nucleo;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

/**
 * 
 * @author Ricardo Rotela González :: rotelabs->gmail.com ;-)
 * @copyright Rotelabs (c)2014
 * 
 */
abstract class PK_Servicios extends PK_Controlador
{
    private static $tipo = 'servicio';
    /**
     * Guarda nuevo registro.
     *
     * @return bool No devuelve nada
     */
    abstract protected function _post();
    /**
     * Elimina un registro por su id.
     *
     * @param  int $id Id del registro a eliminar
     *
     * @return bool No devuelve nada
     */
    abstract protected function _delete($id = 0);
    /**
     * Modifica un registro por su id.
     *
     * @param  int $id Id del registro a modificar
     *
     * @return bool No devuelve nada
     */
    abstract protected function _put($id = 0);
    /**
     * Consulta u obtiene un registro por el Id, o todos sin el id.
     *
     * @param  int $id Id del registro a consultar
     *
     * @return array      Debe devolver un array del o los registros
     */
    abstract protected function _get($id = 0);
    // Propiedades
    private $entradas = array();
    // Funciones
    public function __construct()
    {
        parent::__construct();
        $entradas = array();
        $texto = html_entity_decode(@file_get_contents('php://input'), ENT_QUOTES, 'UTF-8');

        switch (es_metodo()) {
            case 'POST':
                if (count($_POST) > 0) {
                    $entradas = array_merge($entradas, $_POST);
                } else {
                    $otros = (array) json_decode($texto);
                    if (count($otros) > 0) {
                        $entradas = array_merge($entradas, $otros);
                    }
                }
                break;

            case 'GET':
                $entradas = array_merge($entradas, $_GET);
                break;

            case 'PUT':
                $otros = (array) json_decode($texto);

                if (count($otros) > 0) {
                    $entradas = array_merge($entradas, $otros);
                } else {
                    parse_str($texto, $entradas);
                }
                $entradas = array_merge($entradas, $_GET);
                break;

            default:
                $otros = (array) $texto;
                if (count($otros) > 0) {
                    $entradas = array_merge($entradas, $otros);
                }
                break;
        }
        if (isset($entradas['url'])) {
            unset($entradas['url']);
        }
        $this->ayudas('limpiador');
        $this->entradas = sanear($entradas);
    }

    public function hab_cors()
    {
        hab_cors();
    }

    public function principal($param = '')
    {
        switch (es_metodo()) {
            case 'GET':
                $this->_get($param);
                break;
            case 'POST':
                // METODO SAVE (ALTA)
                $this->_post();
                break;
            case 'PUT':
                // METODO PUT (MODIFICACION)
                $this->_put($param);
                break;
            case 'DELETE':
                // METODO DESTROY (BAJA)
                $this->_delete($param);
                break;
            default:
                return $this->_get($param);
                break;
        }
    }

    public function responder($datos = array(), $tipo = 'json', $codigo = 200)
    {
        obt_ayuda('sistema/ayudas/xml_json');
        if (is_array($datos)) {
            // si hay datos y es de tipo array, procesarlo normamente
            if (count($datos) > 0) {
                mostrarxmljson($datos, $tipo, $codigo);
            }
        } else {
            // si no hay datos, enviar no encontrado
            env_cabecera(404, $tipo);
        }
    }

    public function entradas()
    {
        return $this->entradas;
    }

    public static function obtTipo()
    {
        return self::$tipo;
    }
}
