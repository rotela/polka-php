<?php

namespace sistema\librerias;

use sistema\nucleo\PK_Controlador as PK_Controlador;

if (!defined('NUCLEO')) {
    exit('No se permite el acceso directo al script.');
}

class paginador {

    private $tg;
    private $info;

    public function iniciar($config) {
        if (!function_exists('ancla')) {
            PK_Controlador::obt_instancia()->ayudas('html');
        }
        $tot_reg    = $config['total_reg'];
        $reg_pag    = $config['reg_por_pag'];
        $seg        = $config['url_seg'];
        $url        = $config['url_pag'];
        $can_pag    = ceil($tot_reg / $reg_pag);
        $this->info = array(
            'reg_act' => $reg_pag,
            'reg_tot' => $tot_reg,
            'can_pag' => $can_pag
        );
        // si la cantidad de registros es menor o igual a la cantidad de reg por pag
        // se envia solo una pag
        if ($tot_reg <= $reg_pag) {
            $ul = '<ul class="pagination">' . "\n";
            $ul .= '<li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>' . "\n";
            $ul .= '</ul>' . "\n";
            return $ul;
        }
        // si es mayor, seguir con el calculo para conseguir el resto
        for ($i = 0; $i <= $can_pag; $i++) {
            $pag[] = $reg_pag * $i;
        }
        $t = count($pag) - 1;
        unset($pag[$t]);
        //
        $ant = '';
        $sig = '';
        $ini = '';
        $fin = '';
        $act_p = url_seg($seg);
        $act = empty($act_p) ? 0 : (int) $act_p;
        $tt = '';
        foreach ($pag as $c => $i) {
            $eti = $c + 1;
            if ($eti <= $can_pag) {
                if ($act != $i) {
                    $tt .= '<li>' . ancla($eti, $url . $i) . "</li>\n";
                } else {
                    $tt .= '<li class="active"><a href="#">' . $eti . ' <span class="sr-only">(current)</span></a>' . "</li>\n";
                    $a = $c - 1;
                    $s = $c + 1;
                    if (array_key_exists($a, $pag)) {
                        $ant = "<li>" . ancla('<', $url . $pag[$a]) . "</li>\n";
                        $ini = "<li>" . ancla('<<', $url . reset($pag)) . "</li>\n";
                    }
                    if ($eti <= $can_pag) {
                        if (array_key_exists($s, $pag)) {
                            $sig = "<li>" . ancla('>', $url . $pag[$s]) . "</li>\n";
                            $fin = "<li>" . ancla('>>', $url . end($pag)) . "</li>\n";
                        }
                    }
                }
            }
        }
        $ul = '<ul class="pagination">' . "\n";
        $ulf = '</ul>' . "\n";
        $link = $ul . $ini . $ant . $tt . $sig . $fin . $ulf;
        $this->tg = $pag;
        return $link;
    }

    public function info($clave = '') {
        if (empty($clave)) {
            return $this->info;
        } else {
            return $this->info[$clave];
        }
    }

}
