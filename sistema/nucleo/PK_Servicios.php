<?php

namespace sistema\nucleo;

abstract class PK_Servicios extends PK_Controlador {

    /**
     * Guarda nuevo registro
     * @return boolean No devuelve nada
     */
    abstract protected function _post();

    /**
     * Elimina un registro por su id
     * @param  integer $id Id del registro a eliminar
     * @return boolean No devuelve nada
     */
    abstract protected function _delete($id = 0);

    /**
     * Modifica un registro por su id
     * @param  integer $id Id del registro a modificar
     * @return boolean No devuelve nada
     */
    abstract protected function _put($id = 0);

    /**
     * Consulta u obtiene un registro por el Id, o todos sin el id
     * @param  integer $id Id del registro a consultar
     * @return array      Debe devolver un array del o los registros
     */
    abstract protected function _get($id = 0);

    /**
     * Función principal a ejecutar si no se indica el método en la url
     * @return [type] [description]
     */
    abstract protected function principal();

    // Propiedades
    private $entradas = array();

    function __construct() {
        parent::__construct();

        $entradas = array();

        if (count($_POST) > 0) {
            $entradas = array_merge($entradas,$_POST);
        }
        if (count($_GET) > 0) {
            $entradas = array_merge($entradas,$_GET);
        }
        $otros = (array) json_decode(@file_get_contents('php://input'));
        if (count($otros) > 0) {
            $entradas = array_merge($entradas,$otros);;
        }

        $this->ayudas('limpiador');
        $this->entradas = sanear($entradas);
    }

    public function iniciar($id = 0) {
        switch (es_metodo()) {
            case 'GET':
                $this->_get($id);
                break;

            case 'POST':
                // METODO SAVE (ALTA)
                $this->_post();
                break;

            case 'PUT':
                // METODO PUT (MODIFICACION)
                $this->_put($id);
                break;

            case 'DELETE':
                // METODO DESTROY (BAJA)
                $this->_delete($id);
                break;

            default:
                return $this->_get();
                break;
        }
    }

    public function responder($datos = array(), $tipo = 'json', $codigo = 200) {
        if (is_array($datos)) {
            // si hay datos y es de tipo array, procesarlo normamente
            if (count($datos) > 0) {
                cargar('sistema/ayudas/xml_json');
                mostrarxmljson($datos,$tipo,$codigo);
            }
        } else {
            // si no hay datos, enviar no encontrado
            env_cabecera(404, $tipo);
        }
    }

    public function entradas() {
        return $this->entradas;
    }

}

/* Final de archivo PK_Servicios.php */
/* Ubicación: ./sistema/nucleo/PK_Servicios.php */