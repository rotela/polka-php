<?php

namespace sistema\librerias;

class Genxml {

    function __construct() {
        header("Content-type: text/xml; charset=utf-8");
        //{"status":1,"id":"2","nombres":"Bob","apellidos":"Simpson","email":"bobpatino@gmail.com"}
        $xml = new \DomDocument('1.0', 'UTF-8');
        $root = $xml->createElement('clientes');
        $root = $xml->appendChild($root);

        $cliente = $xml->createElement('cliente');
        $cliente = $root->appendChild($cliente);


        $id = $xml->createElement('id', '2');
        $id = $cliente->appendChild($id);

        $nom = $xml->createElement('nombre', 'Erick');
        $nom = $cliente->appendChild($nom);

        $apellido = $xml->createElement('apellido', 'campos');
        $apellido = $cliente->appendChild($apellido);

        $xml->formatOutput = true;

        $strings_xml = $xml->saveXML();
        echo $strings_xml;
        //$xml->save('XML/prueba.xml');
    }

}
