<?php

namespace sistema\librerias;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

use sistema\nucleo\PK_Singleton ;

class estructura_bd
{
    use PK_Singleton ;
    private $tablas = array();

    public function obtener($tabla = '')
    {
        $tabla = strtoupper($tabla);

        if (array_key_exists($tabla, $this->tablas)) {
            return $this->tablas[$tabla];
        } else {
            $archivo = "aplicacion/modelos/estructuras/$tabla.php";
            $archivo = str_replace('\\', SD, $archivo);
            if (file_exists($archivo)) {
                include $archivo;
                $this->tablas[$tabla] = $config;
                return $this->tablas[$tabla];
            } else {
                return array();
            }
        }
    }
    public function escribir($datos=array(), $tabla = '')
    {
        $tabla = strtoupper($tabla);
        $archivo = "aplicacion/modelos/estructuras/$tabla.php";
        $archivo = str_replace('\\', SD, $archivo);

        if (!file_exists($archivo)) {
            if (count($datos)>0) {
                $contenido = "<?php\n";
                $contenido .= "// Archivo generado automáticamente por el núcleo del sistema\n";
                $contenido .= "if (!defined('SISTEMA')) {\n";
                $contenido .= "\texit('No se permite el acceso directo al script.');\n";
                $contenido .= "}\n";
                $contenido .= "\n";
                $contenido .= "// Estructura de la tabla '$tabla'\n";
                $contenido .= "// Eliminar éste archivo si la tabla '$tabla' tiene algún cambio en su estructura\n";

                $contenido .= "\$config = array(\n";
                foreach ($datos as $key => $value) {
                    $campo = $value['FIELD_NAME'];
                    $tipo = $value['FIELD_TYPE'];
                    $contenido .= "\t'$campo' => '$tipo',\n";
                }
                $contenido .= ");\n";

                $contenido .= "\n";
                $contenido .= "// Creación: '".fecha_a(fecha_hora(), 'd-m-Y H:i:s')."'\n";
                $contenido .= "// Final del archivo: '$archivo'\n";

                //escribimos el archivo
                if (!$gestor = fopen($archivo, 'a')) {
                    informe('Seguimiento', "No se puede abrir el archivo ($archivo)");
                }

                // Escribir $contenido a nuestro archivo abierto.
                if (fwrite($gestor, $contenido) === false) {
                    informe('Seguimiento', "No se puede escribir en el archivo ($archivo)");
                }
                fclose($gestor);
            }
        }
    }
}
