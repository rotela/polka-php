<?php
if (!defined('APLICACION')) {
    exit('No se permite acceso directo al script');
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?= ap_titulo(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= url_base('sistema/vistas/css/') . 'bootstrap.min.css'; ?>" rel="stylesheet" >
        <link href="<?= url_base('sistema/vistas/css/') . 'index.css'; ?>" rel="stylesheet" >
    </head>
    <body>
        <div id="wrap">
            <nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= url_base(); ?>"><?= ap_titulo(); ?></a>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav">
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container">
                <h1>Polka-php</h1>
                <h2>Marco de Desarrollo</h2>
                <h3>es fácil, rápido, seguro, gratis y en tú Idioma!!!</h3>
                <hr>
                <p>Polka-php es un marco de desarrollo echo en y para php. Permite desarrollar 
                    aplicaciones mucho más rápido ya que no es necesario empezar desde cero. 
                    Polka-php brinda varias herramientas para el desarrollo de aplicaciones, 
                    cuenta con poderosas librerías, ayudantes y varios componentes que hará más 
                    placentero escribir código, dejando que programador se concentre en la lógica 
                    de negocio y no en la estructura. Polka-php brinda una estructura básica 
                    pero poderosa sobre la cual se puede desarrollar aplicaciones simple como complejas.</p>

                <a class="btn btn-success" href="https://github.com/rotela/polka-php">
                    <span class="glyphicon glyphicon-ok"></span>
                    Github
                </a>
                <a class="btn btn-primary" href="https://github.com/rotela/polka-php/wiki">
                    <span class="glyphicon glyphicon-ok"></span>
                    Wiki
                </a>
                <br><br>
                <!-- secciones -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Características</h3>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li>Modelo de Abstracción de datos</li>
                                    <li>Manejador de plantillas</li>
                                    <li>Manejos de sesiones</li>
                                    <li>Url limpias (amigables)</li>
                                    <li>Manejos de formularios</li>
                                    <li>Manejos de seguridad</li>
                                    <li>Disparadores, hack's...</li>
                                    <li>Librerías, Ayudantes</li>     
                                    <li>y muchas otras...</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Soporte para bases de datos</h3>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li>Mysql 3, 4 y 5</li>
                                    <li>PostgreSQL</li>
                                    <li>Oracle CAll Interface</li>
                                    <li>SQLite 2 y 3</li>
                                    <li>ODBC v3</li>
                                    <li>Microsoft SQL Server / SQL Azure</li>
                                    <li><a href="http://php.net/manual/es/pdo.drivers.php">otros</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Es para ti si quieres</h3>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li>Pequeña curva de aprendizaje</li>
                                    <li>Un marco de desarrollo pequeño y poderoso</li>
                                    <li>Excelente rendimiento</li>
                                    <li>Amplia compatibilidad con los alojamientos estándar</li>
                                    <li>Libertad, no requiere reglas de codificación restrictivas</li>
                                    <li>Cero código/s intrusivo/s</li>
                                    <li>Soluciones simples a sistemas grandes y/o complejos</li>
                                    <li>Pasar más tiempo lejos de la computadora</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container">
            <p class="muted credit pie">Marco de desarrollo | página renderizada en <?= tiempo_fin(); ?> s/ms con <?= memoria_usada(); ?> MB<br>
<?= ap_titulo() . ' ' . ap_version(); ?> | Copyright 2014©</p>
        </div>
    </div>
    <script src="<?= url_base('sistema/vistas/js/') . 'jquery.js'; ?>"></script>
    <script src="<?= url_base('sistema/vistas/js/') . 'bootstrap.min.js'; ?>"></script>
</body>
</html>
