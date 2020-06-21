<?php

(!defined('APLICACION')) ? exit('No se permite el acceso directo al script.') : false;

// Respete la cantidad de argumentos (?) entre el origen y destino.
// El índice de $config es el destino y su valor es el destino,
$config['origen/?'] = 'destino/metodo/?';
