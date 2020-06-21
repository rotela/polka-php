<?php

namespace sistema\librerias;

(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;

use sistema\nucleo\PK_Singleton;

/**
 * Class estructura_bd  Esta clase crea los archivos de estructuras de las tablas de los modelos
 */
class estructura_bd
{
    use PK_Singleton;
    private $tablas = array();

    public function obtener(string $tabla = '')
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

    public function escribir(array $datos = array(), string $tabla = '')
    {
        $carpeta = 'aplicacion/modelos/estructuras';

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        
        $tabla = strtoupper($tabla);
        $archivo = "$carpeta/$tabla.php";
        $archivo = str_replace('\\', SD, $archivo);

        if (!file_exists($archivo)) {
            if (count($datos) > 0) {
                $contenido = "<?php\n";
                $contenido .= "// Archivo generado automáticamente por el núcleo del sistema\n";
                $contenido .= "(!defined('SISTEMA')) ? exit('No se permite el acceso directo al script.') : false;\n";
                $contenido .= "\n";
                $contenido .= "// Estructura de la tabla '$tabla'\n";
                $contenido .= "// Eliminar éste archivo si la tabla '$tabla' tiene algún cambio en su estructura\n";
                $contenido .= "\$config = array(\n";

                foreach ($datos as $key => $value) {
                    $campo = $value['CAMPO'];
                    $tipo = (strpos($value['TIPO'], '(') === false) ? strtoupper($value['TIPO']) : strtoupper(strstr($value['TIPO'], '(', true));
                    $contenido .= "\t'$campo' => '$tipo',\n";
                }

                $contenido .= ");\n";
                $contenido .= "\n";
                $contenido .= "// Creación: '" . fecha_a(fecha_hora(), 'd-m-Y H:i:s') . "'\n";
                $contenido .= "// Final del archivo: '$archivo'\n";

                // abrimos en forma de lectura y escritura al archivo
                if (!$gestor = fopen($archivo, 'a')) {
                    informe('Seguimiento', "No se puede abrir el archivo ($archivo)");
                }
                // escribir $contenido a nuestro archivo abierto.
                if (fwrite($gestor, $contenido) === false) {
                    informe('Seguimiento', "No se puede escribir en el archivo ($archivo)");
                }
                // cerramos el archivo
                fclose($gestor);
            }
        }
    }
}
