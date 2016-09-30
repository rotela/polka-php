<?php

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}
/**
 * Muestra el contenido indicado al navegador.
 *
 * @param string $texto Contenido
 *
 * @return mixed Salida al navegador
 */
function eco($texto = '')
{
    echo $texto.' ';
}
/**
 * Muestra el contenido indicado al navegador
 * con salto de linea al final.
 *
 * @param string $texto Contenido
 *
 * @return mixed Salida al navegador
 */
function eco_l($texto = '')
{
    echo "$texto<br>";
}
/**
 * Muestra el contenido indicado al navegador
 * con salto de linea y retorno de carro al final.
 *
 * @param string $texto Contenido
 *
 * @return mixed Salida al navegador
 */
function eco_ln($texto = '')
{
    echo "$texto<br>\n";
}
function println($texto = '')
{
    echo "$texto<br>\n";
}
if (!function_exists('pre_var_dump')) {
    function pre_var_dump($arreglo = array())
    {
        if (count($arreglo) > 0) {
            echo '<pre>';
            var_dump($arreglo);
            exit();
        }
    }
}
if (!function_exists('pre_objetos')) {
    function pre_objetos($arreglo = array())
    {
        if (count($arreglo) > 0) {
            echo '<pre>';
            var_dump($arreglo);
            exit();
        }
    }
}
if (!function_exists('eco_pre')) {
    function eco_pre($arreglo = array())
    {
        if (count($arreglo) > 0) {
            echo '<pre>';
            print_r($arreglo);
            exit();
        }
    }
}
