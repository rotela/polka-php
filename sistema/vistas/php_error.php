<?php

function extraer_error($mensaje) {
    $e = '';
    foreach ($mensaje as $key => $value) {
        if (is_array($value)) {
            extraer_error($mensaje);
        } else {
            $e.="<dt>$key</dt>\n";
            if ($key == 'type') {
                $e.="<dd>" . tipo_error($value) . "</dd>\n";
            } else {
                $e.="<dd>$value</dd>\n";
            }
        }
    }
    echo $e;
}

function tipo_error($clave = 0) {
    $tipoerror[1] = 'Error';
    $tipoerror[2] = 'Warning';
    $tipoerror[4] = 'Parsing Error';
    $tipoerror[8] = 'Notice';
    $tipoerror[16] = 'Core Error';
    $tipoerror[32] = 'Core Warning';
    $tipoerror[64] = 'Compile Error';
    $tipoerror[128] = 'Compile Warning';
    $tipoerror[256] = 'User Error';
    $tipoerror[512] = 'User Warning';
    $tipoerror[1024] = 'User Notice';
    $tipoerror[2048] = 'Runtime Notice';
    $tipoerror[4096] = 'Recoverable Error';
    $tipoerror[8192] = 'Deprecate';
    $tipoerror[16384] = 'User Deprecate';
    $tipoerror[32767] = 'E ALL';
    return $tipoerror[$clave];
}
?>
<div class="alert alert-danger">
    Ups! un error php fué encontrado
</div>
<div class="panel panel-danger">
    <div class="panel-heading">Detalle</div>
    <div class="panel-body">
        <dl class="dl-horizontal">
<?php extraer_error($mensaje); ?>
        </dl>
    </div>
</div>