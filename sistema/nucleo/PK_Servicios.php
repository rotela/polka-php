<?php

namespace sistema\nucleo;

abstract class PK_Servicios extends PK_Controlador {
  private static $tipo='servicio';
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

  // Propiedades
  private $entradas = array();

  function __construct() {
    parent::__construct();

    $entradas = array();

    switch (es_metodo()) {
      case 'POST':

        if (count($_POST)>0) {
          # code...
          $entradas = array_merge($entradas,$_POST);
        }else{
          $otros = (array) json_decode(@file_get_contents('php://input'));
          if (count($otros) > 0) {
            $entradas = array_merge($entradas,$otros);;
          }
        }
        break;

      case 'GET':
        $entradas = array_merge($entradas,$_GET);
        break;

      case 'PUT':
        parse_str(@file_get_contents("php://input"),$entradas);
        $entradas = array_merge($entradas,$_GET);
        break;

      default:
        $otros = (array) json_decode(@file_get_contents('php://input'));
        if (count($otros) > 0) {
          $entradas = array_merge($entradas,$otros);;
        }
        break;
    }
    /*
    if (count($_POST) > 0) {
    $entradas = array_merge($entradas,$_POST);
  }
  if (count($_GET) > 0) {
  $entradas = array_merge($entradas,$_GET);
}
*/



$this->ayudas('limpiador');
$this->entradas = sanear($entradas);
}
public function hab_cors(){
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
  }

  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  }
}
public function principal($param='') {
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

public function responder($datos = array(), $tipo = 'json', $codigo = 200) {
  cargar('sistema/ayudas/xml_json');
  if (is_array($datos)) {
    // si hay datos y es de tipo array, procesarlo normamente
    if (count($datos) > 0) {
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

public static function obtTipo(){
  return self::$tipo;
}

}

/* Final de archivo PK_Servicios.php */
/* Ubicación: ./sistema/nucleo/PK_Servicios.php */
