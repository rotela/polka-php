<?php

if (!function_exists('cliente_ip')) {

    function cliente_ip() {
        return $_SERVER['REMOTE_ADDR'];
    }

}
if (!function_exists('cliente_nav')) {

    function cliente_nav() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

}

if (!function_exists('es_ajax')) {

    function es_ajax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('es_post')) {

    function es_post() {
        return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
    }

}
if (!function_exists('es_get')) {

    function es_get() {
        return ($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false;
    }

}
if (!function_exists('es_metodo')) {

    function es_metodo() {
        return $_SERVER['REQUEST_METHOD'];
    }

}