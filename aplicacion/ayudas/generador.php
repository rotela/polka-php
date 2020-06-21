<?php

(!defined('APLICACION')) ? exit('No se permite el acceso directo al script.') : false;

/**
 * Este es un ejemplo de archivo de ayuda propio del usuario
 * text_generador(par 1, par 2)
 * Parámetro 1: $can
 * int = Entero que representa la cantidad de caracteres
 * a generar, el mínimo a generar es 4 dígitos (por defecto 5)
 * Ejemplo:
 * text_generador(5) devolverá 'bcead' (aleatorio).
 *
 * Parámetro 2: $mezcla
 * string = con las siguientes opciones
 * az | Sólo letras de la 'a' a la 'z'
 * 09 | Sólo números de '0' al '9'
 * a0 | Mezcla de letras y números (por defecto)
 */
if (!function_exists('text_generador')) {
    function text_generador($can = 5, $mezcla = 'a0')
    {
        $min = 3;
        $asc = 0;
        if ($can < 4) {
            $can = $min;
        } else {
            --$can;
        }
        switch ($mezcla) {
            case '09':
                $n = '';
                for ($i = 0; $i <= $can; ++$i) {
                    $asc = rand(48, 57);
                    $n .= chr($asc);
                }
                break;

            case 'az':
                $n = '';
                for ($i = 0; $i <= $can; ++$i) {
                    $asc = rand(97, 122);
                    $n .= chr($asc);
                }
                break;

            case 'a0':
                $n = '';
                $nw = array();
                $ig = 0;
                if (fmod($can, 2) == 0) {
                    $ig = ($can / 2);
                } else {
                    $ig = ($can / 2);
                    $ig = round($ig);
                }
                for ($i = 1; $i <= $can; ++$i) {
                    if ($i <= $ig) {
                        $asc = rand(48, 57);
                        $nw[$i] = chr($asc);
                    } else {
                        $asc = rand(97, 122);
                        $nw[$i] = chr($asc);
                    }
                }
                shuffle($nw);
                foreach ($nw as $value) {
                    $n .= $value;
                }
                break;

            default:
                $n = '';
                for ($i = 0; $i <= $can; ++$i) {
                    $asc = rand(48, 57);
                    $n .= chr($asc);
                }
                break;
        }

        return $n;
    }
}
