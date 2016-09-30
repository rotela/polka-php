<?php

namespace sistema\librerias;

class genxml
{
    public function mostrar($result, $tipo = 'xml', $codigo = 200)
    {
        $this->env_cabecera($codigo, $tipo);
        if (strtolower($tipo) == 'json') {
            echo json_encode($result);
        } elseif (strtolower($tipo) == 'xml') {
            echo '<?xml version="1.0"?>';
            echo '<resultados>';
            $xml_array = json_decode(json_encode($result), true);
            $this->xmlExplorador($xml_array, 'registroo');
            echo '</resultados>';
        } else {
            echo json_encode($result);
        }
    }

    private function xmlExplorador($xml_array, $parent)
    {
        foreach ($xml_array as $tag => $value) {
            if ((int) $tag === $tag) {
                $tag = mb_substr($parent, 0, -1);
            }
            echo '<'.$tag.'>';
            if (is_array($value)) {
                $this->xmlExplorador($value, $tag);
            } else {
                echo $value;
            }
            echo '</'.$tag.'>';
        }
    }

    private function env_cabecera($codigo = 200, $tipo = 'json')
    {
        header('HTTP/1.1 '.$codigo.' '.$this->obt_estado($codigo));
        header('Content-type:application/'.$tipo.';charset=utf-8');
    }

    private function obt_estado($codigo)
    {
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
            500 => 'Internal Server Error',
        );

        return $estado[$codigo];
    }
}
