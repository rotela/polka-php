<?php

namespace sistema\librerias;

if (!defined('NUCLEO')) {
    exit('No se permite el acceso directo al script.');
}

class genpdf extends fpdf {

    private $tit_col = array();
    private $tam_col = array();
    private $mar_izq = 0;
    private $orientacion = 'P';

    public function __construct($param = '') {
        if (empty($param)) {
            parent::__construct();
        } else {
            parent::__construct($param);
        }
    }

    public function orientacion($orie = 'P', $hoja = 'A4') {
        $this->orientacion = $orie;
        $this->SetAutoPageBreak(true, 3);
        $this->AliasNbPages();
        $this->AddPage($orie, $hoja);
    }

    public function env_tit_col($titulos = array()) {
        $this->tit_col = $titulos;
    }

    public function env_tam_col($tamanos = array()) {
        $this->tam_col = $tamanos;
    }

    public function env_mar_izq($mar = 0) {
        $this->mar_izq = $mar;
    }

    public function env_titulo($value = '') {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        // $this->Cell(80,0);
        // Título
        $this->Cell(0, 10, $value, 1, 0, 'C');
        // Salto de línea
        $this->Ln(12);
    }

    public function detalles($datos = array()) {
        $this->SetFont('times', 'B', 10);
        //recorro los titulos
        if (!empty($this->mar_izq)) {
            $this->Cell($this->mar_izq, 8);
        }
        foreach ($datos[0] as $key => $fila) {
            $tit_col = $key;
            if (array_key_exists($key, $this->tit_col)) {
                $tit_col = $this->tit_col[$key];
            }
            if (array_key_exists($key, $this->tam_col)) {
                $ancho = $this->tam_col[$key];
            } else {
                $ancho = 50;
            }
            $this->Cell($ancho, 8, $tit_col, 1, 0, 'C');
        }
        $this->Ln(8);
        //
        $this->SetFont('Times', '', 12);
        foreach ($datos as $fila) {
            if (!empty($this->mar_izq)) {
                $this->Cell($this->mar_izq, 8);
            }
            foreach ($fila as $key => $value) {
                if (array_key_exists($key, $this->tam_col)) {
                    $ancho = $this->tam_col[$key];
                } else {
                    $ancho = 50;
                }
                $this->Cell($ancho, 8, $value, 1, 0);
            }
            $this->Ln(8);
        }
        if (!empty($this->mar_izq)) {
            $this->Cell($this->mar_izq, 8);
        }
    }

    public function cabecera($datos = array(), $ancho = 50) {
        $this->SetFont('helvetica', 'B', 10);
        //recorro los titulos
        foreach ($datos as $key => $fila) {
            if (!empty($this->mar_izq)) {
                $this->Cell($this->mar_izq, 8);
            }
            $tit_col = $key;
            if (array_key_exists($key, $this->tit_col)) {
                $tit_col = $this->tit_col[$key];
            }
            $this->Cell($ancho, 8, $tit_col, 1, 0, 'R');
            $this->Cell($ancho, 8, $fila, 1, 0);
            $this->Ln(8);
        }
        $this->Ln(8);
    }

    public function pie($value = '') {
        // Posición: a 1,5 cm del final
        if ($this->orientacion == 'P') {
            $this->SetY(280);
        } else {
            $this->SetY(190);
        }
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pág ' . $this->PageNo() . ' de {nb}', 1, 0, 'C');
    }

}
