<?php

obt_ayuda('arreglos');

function obt_xml($result,$codigo=200) {
    $result = convertir_utf8($result);
    mostrarxmljson($result,$tipo='xml',$codigo);
}

function obt_json($result,$codigo=200) {
    $result = convertir_utf8($result);
    mostrarxmljson($result,$tipo='json',$codigo);
}

function mostrarxmljson($result,$tipo='xml',$codigo=200) {
    env_cabecera($codigo, $tipo);
    if (strtolower($tipo) == "json") {
        echo json_encode($result,JSON_NUMERIC_CHECK);
    } else if (strtolower($tipo) == "xml") {
        echo '<?xml version="1.0"?>';
        echo "<resultados>";
        $xml_array = json_decode(json_encode($result), true);
        xmlExplorador($xml_array, "registroo");
        echo "</resultados>";
    } else {
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
}

function xmlExplorador($xml_array, $parent) {
    foreach($xml_array as $tag => $value) {
        if ((int)$tag === $tag) {
            $tag = mb_substr($parent, 0, -1);
        }
        echo "<" .$tag. ">";
        if (is_array($value)) {
            xmlExplorador($value, $tag);
        } else {
            echo $value;
        }
        echo "</" .$tag. ">";
    }
}

function env_cabecera($codigo = 200, $tipo = 'json') {
    header("HTTP/1.1 " . $codigo . " " . obt_estado_envio($codigo));
    header('Content-type:application/' . $tipo . ';charset=utf-8');
}

function obt_estado_envio($codigo) {
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
