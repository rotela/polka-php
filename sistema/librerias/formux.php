<?php

namespace sistema\librerias;

if (!defined('SISTEMA')) {
    exit('No se permite el acceso directo al script.');
}

class formux {

    public $formulario;
    public $etiquetas;
    public $campos;
    public $areas;
    public $lineas = array();
    public $codigo = '';
    public $saltoString = '<br>';
    public $sinAperturaForm = FALSE; //establecer TRUE si NO desea abrir el form (<form>)
    public $sinCierreForm = TRUE; //establecer TRUE si NO desea cerrar el form (</form>)
    public $saltoEntrada = FALSE; //estables TRUE si deseas que los inputs tenga salto de linea tipo <br />
    public $hayEtiqueta = FALSE;
    public $hayCampo = FALSE;

    function __construct($frNombre = 'MiFormulario', $frcAcion = '#', $frMetodo = 'POST', $apertura = FALSE) {
        if ($apertura)
            $this->formulario($frNombre = 'MiFormulario', $frAccion = '#', $frMetodo = 'POST');
    }

    function formulario($frNombre = 'MiFormulario', $frAccion = '#', $frMetodo = 'POST') {
        $this->lineas[] = '<form name="' . $frNombre . '" action="' . $frAccion . '" method="' . $frMetodo . '">' . "\n";
    }

    function agr_string($param) {
        $this->lineas[] = $param;
    }

    function agr_enviar($nombre = 'enviar', $valor = 'Enviar') {
        $this->lineas[] = '<input type="submit" value="' . $valor . '" name="' . $nombre . '" />' . "\n";
    }

    function agr_etiqueta($etiEtiqueta = 'Etiqueta', $etiPara = '', $atributos = array()) {
        $etiqueta = '<label ';
        if (count($atributos) > 0) {
            foreach ($atributos as $key => $value) {
                $etiqueta .= $key . '="' . $value . '" ';
            }
        }
        if (empty($etiPara)) {
            $etiqueta .= 'for="' . $etiEtiqueta . '" >' . $etiEtiqueta . '</label>' . "\n";
        } else {
            $etiqueta .= 'for="' . $etiPara . '" >' . $etiEtiqueta . '</label>' . "\n";
        }
        $this->etiquetas[] = $etiqueta;
        $this->lineas[] = $etiqueta;
        $this->hayEtiqueta = TRUE;
    }

    function agr_campo($camNombre = 'MiCampo', $camId = '', $valor = '', $tipo = 'text', $size = 50) {
        $campo = '';
        $salto = '';
        if (empty($tipo))
            $tipo = 'text';
        if ($this->saltoEntrada)
            $salto = $this->saltoString;
        if (empty($camId)) {
            $campo = '<input type="' . $tipo . '" id="' . $camNombre . '" name="' . $camNombre . '" value="' . $valor . '" size="' . $size . '" />' . $salto . "\n";
        } else {
            $campo = '<input type="' . $tipo . '" id="' . $camId . '" name="' . $camNombre . '" value="' . $valor . '" size="' . $size . '" />' . $salto . "\n";
        }
        $this->campos[] = $campo;
        $this->lineas[] = $campo;
        $this->hayCampo = TRUE;
    }

    function agr_area($areaNombre = 'MiArea', $valor = '', $rows = 4, $cols = 20) {
        $salto = '';
        if ($this->saltoEntrada)
            $salto = $this->saltoString;
        $area = '<textarea id="' . $areaNombre . '" name="' . $areaNombre . '" rows="' . $rows . '" cols="' . $cols . '">' . $valor . '</textarea>' . $salto . "\n";
        $this->areas[] = $area;
        $this->lineas[] = $area;
    }

    function agr_selector($nombre, $opciones, $id = '', $seleccion = '', $atributos = array()) {
        $salto = '';
        if ($this->saltoEntrada)
            $salto = $this->saltoString;
        if (empty($id))
            $id = $nombre;
        if (!empty($nombre)) {
            if (!empty($opciones)) {
                foreach ($opciones as $valor) {
                    foreach ($valor as $key => $value) {
                        $x[] = $valor[$key];
                    }
                    $filas[] = array(
                        'valor' => $x[0],
                        'etiqueta' => $x[1]);
                    unset($x);
                }
                $conca = '';
                $select = array();
                $txt = '<select name="' . $nombre . '" id="' . $id . '" ';
                if (count($atributos) > 0) {
                    foreach ($atributos as $key => $value) {
                        $txt .= $key . '="' . $value . '" ';
                    }
                }
                $txt .= '>' . "\n";
                $select[] = $txt;

                foreach ($filas as $value) {
                    if ($seleccion == $value['valor']) {
                        $select[] = '<option value="' . $value['valor'] . '" selected="selected">' . $value['etiqueta'] . '</option>' . "\n";
                    } else {
                        $select[] = '<option value="' . $value['valor'] . '">' . $value['etiqueta'] . '</option>' . "\n";
                    }
                }
                $select[] = '</select>' . $salto . "\n";
                foreach ($select as $value) {
                    $conca .= $value;
                }
                $this->lineas[] = $conca;
            }
        }
    }

    function generar($imprimir = FALSE) {
        if (!$this->sinCierreForm)
            $this->lineas[] = '</form>' . "\n"; //última linea de codigo del form

        foreach ($this->lineas as $lineas) {
            $this->codigo .= $lineas;
        }
        if ($imprimir) {
            echo $this->codigo;
        } else {
            return $this->codigo;
        }
    }

    function limpiar_cache() {
        $this->codigo = '';
        $this->lineas = array();
    }

}

// FIN formux Class
/* FIN de archivo formux.php */
/* Location: libraries/formux.php */