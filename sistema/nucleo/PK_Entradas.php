<?php
namespace sistema\nucleo;
if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
/**
 * POR EL MOMENTO NO LE ENCONTRÉ UTILIDAD A ESTA CLASE
 */
class PK_Entradas
{
	private $post;
	private $get;
	private $sanear;
	use PK_Singleton;
	private function __construct()
	{
		$this->post=$_POST;
	}
	public function hay_post()
	{
		return $_POST;
	}
	public function obt_post($nom='')
	{
		if (count($_POST)>0) {
			if (!empty($nom)) {
				if (!array_key_exists($nom,$_POST)) {
					return '';
				}else{
					return ($this->sanear) ? $this->post[$nom] : $_POST[$nom];
				}
			}else{
				return ($this->sanear) ? $this->post : $_POST;
			}
		}else{
			return ($this->sanear) ? $this->post : $_POST;
		}
	}
	public function sanear($sanear=TRUE)
	{
		$this->sanear = $sanear;
		$nuevo        = array();
		foreach ($this->post as $key => $value) {
			if (is_string($value)) {
				$nuevo[$key]=filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
			}else if (is_numeric($value)) {
				$nuevo[$key]=filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);
			}else{
				$nuevo[$key]=$value;
			}
		}
		$this->post = $nuevo;
		return $this->post;
	}
}