<?php

namespace sistema\nucleo;

abstract class PK_Servicios extends PK_Controlador {

    /**
     * Guarda nuevo registro
     * @return boolean No devuelve nada
     */
    abstract protected function _alta();

    /**
     * Elimina un registro por su id
     * @param  integer $id Id del registro a eliminar
     * @return boolean No devuelve nada
     */
    abstract protected function _baja($id = 0);

    /**
     * Modifica un registro por su id
     * @param  integer $id Id del registro a modificar
     * @return boolean No devuelve nada
     */
    abstract protected function _modificacion($id = 0);

    /**
     * Consulta u obtiene un registro por el Id, o todos sin el id
     * @param  integer $id Id del registro a consultar
     * @return array      Debe devolver un array del o los registros
     */
    abstract protected function _consulta($id = 0);

    /**
     * Función principal a ejecutar si no se indica el método en la url
     * @return [type] [description]
     */
    abstract protected function principal();

    // Propiedades
    private $entradas = array();

    function __construct() {
        parent::__construct();
        if (count($_POST) > 0) {
            $this->entradas = $_POST;
        } else {
            $this->entradas = (array) json_decode(@file_get_contents('php://input'));
        }
        $this->ayudas('limpiador');
        $this->entradas = sanear($this->entradas);
    }

    public function iniciar($id = 0) {
        switch (es_metodo()) {
            case 'GET':
                if (!empty($id)) {
                    // METODO FECHT CON ID (CONSULTAR - OBTENER - UNITARIO)
                    $this->_consulta($id);
                } else {
                    // METODO FECHT SIN ID (TODAS)
                    $this->_consulta();
                }
                break;

            case 'POST':
                // METODO SAVE (ALTA)
                if (empty($id)) {
                    $this->_alta();
                }
                break;

            case 'PUT':
                // METODO PUT (MODIFICACION)
                $this->_modificacion($id);
                break;

            case 'DELETE':
                // METODO DESTROY (BAJA)
                if (!empty($id)) {
                    $this->_baja($id);
                }
                break;

            default:
                return $this->_consulta();
                break;
        }
    }

    public function responder($datos = array(), $codigo = 200, $tipo = 'json') {
        if (is_array($datos)) {
            // si hay datos y es de tipo array, procesarlo normamente
            $this->env_cabecera($codigo, $tipo);
            if (count($datos) > 0) {
                if ($tipo == 'json') {
                    echo json_encode($datos);
                }
            }
        } else {
            // si no hay datos, enviar no encontrado
            $this->env_cabecera(404, $tipo);
        }
    }

    private function env_cabecera($codigo = 200, $tipo = 'json') {
        header("HTTP/1.1 " . $codigo . " " . $this->obt_estado($codigo));
        header('Content-Type:application/' . $tipo . ';charset=utf-8');
    }

    private function obt_estado($codigo) {
        $estado = array(
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            204 => 'No Content',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        );
        return $estado[$codigo];
    }

    public function entradas() {
        return $this->entradas;
    }

}

/* Final de archivo PK_Servicios.php */
/* Ubicación: ./sistema/nucleo/PK_Servicios.php */