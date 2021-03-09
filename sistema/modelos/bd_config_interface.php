<?php

namespace sistema\modelos;

interface bd_config_interface
{
    const host = '';
    // Puerto de la base datos
    const port = '';
    // Tipo de datos (pgsql, mysql, sqlite)
    const tipo = '';
    // Usuario de la base de datos
    const user = '';
    // Password de la base de datos
    const pass = '';
    // Base de datos a utilizar
    const base = '';
    // Cotejamiento de la datos a utilizar
    const cote = '';
    // Sufijo de tablas
    const sufi = '';
}
