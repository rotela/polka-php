<?php
if (!defined('SISTEMA')) {
    exit('No se permite acceso directo al script');
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?= pk_titulo(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= $css . 'bootstrap.min.css'; ?>" rel="stylesheet" >
        <link href="<?= $css . 'index.css'; ?>" rel="stylesheet" >
    </head>
    <body>
        <div id="wrap">
            <!--<nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">-->
            <nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?= url_base(); ?>"><?= pk_titulo(); ?></a>
                    </div>
                </div>
            </nav>
            <div class="container">
                <?= isset($contenido) ? $contenido : 'Contenido vacío.'; ?>
            </div>
            <div id="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <p class="muted credit pie">Marco de desarrollo | página renderizada en <?= tiempo_fin(); ?> s/ms con <?= memoria_usada(); ?> MB<br>
                    <?= pk_titulo() . ' ' . pk_version(); ?> | Copyright 2014©</p>
            </div>
        </div>
        <script src="<?= $js . 'jquery.js'; ?>"></script>
        <script src="<?= $js . 'bootstrap.min.js'; ?>"></script>
    </body>
</html>