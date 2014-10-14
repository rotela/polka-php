<?php if (!defined('SISTEMA')) exit('No se permite el acceso directo al script.');
/**
 * Muestra el contenido indicado al navegador
 * @package ayudas
 * @subpackage ecos
 * @param  string $texto Contenido
 * @return mixed        Salida al navegador
 */
function eco($texto='')
{
	echo $texto.' ';
}
/**
 * Muestra el contenido indicado al navegador
 * con salto de linea al final
 * @package ayudas
 * @subpackage ecos
 * @param  string $texto Contenido
 * @return mixed         Salida al navegador
 */
function eco_l($texto='')
{
	echo "$texto<br>";
}
/**
 * Muestra el contenido indicado al navegador
 * con salto de linea y retorno de carro al final
 * @package ayudas
 * @subpackage ecos
 * @param  string $texto Contenido
 * @return mixed         Salida al navegador
 */
function eco_ln($texto='')
{
	echo "$texto<br>\n";
}