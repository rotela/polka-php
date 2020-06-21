<?php (!defined('APLICACION')) ? exit('No se permite acceso directo al script') : false; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?= ap_titulo(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= vista_css('w3.css'); ?>" rel="stylesheet">
</head>

<body>

    <header class="w3-row  w3-black">
        <div class="w3-col w3-container" style="width:20%"></div>
        <div class="w3-col w3-container" style="width:60%">
            <h3>Polka-php</h3>
        </div>
        <div class="w3-col w3-container" style="width:20%"></div>
    </header>

    <div class="w3-row">
        <div class="w3-col w3-container" style="width:20%"></div>
        <div class="w3-col w3-container" style="width:60%">
            <?= isset($contenido) ? $contenido : 'Contenido vacío.'; ?>
        </div>
        <div class="w3-col w3-container" style="width:20%"></div>
    </div>

    <footer class="w3-row w3-bottom w3-blue-grey">
        <div class="w3-col w3-container" style="width:20%"></div>
        <div class="w3-col w3-container" style="width:60%">
            <p><?= ap_titulo() . ' ' . ap_version(); ?> | Página renderizada en <?= tiempo_fin(); ?> s/ms con <?= memoria_usada(); ?> | <?= ap_derechos(); ?></p>
        </div>
        <div class="w3-col w3-container" style="width:20%"></div>
    </footer>

</body>

</html>