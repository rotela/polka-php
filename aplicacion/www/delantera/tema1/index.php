<?php (!defined('APLICACION')) ? exit('No se permite acceso directo al script') : false; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?= ap_titulo(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= vista_css('w3.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <header class="w3-row">
        <div class="w3-col w3-container" style="width:20%"></div>
        <div class="w3-col w3-container w3-blue-grey" style="width:60%">
            <h3>Marco de Desarrollo</h3>
        </div>
        <div class="w3-col w3-container" style="width:20%"></div>
    </header>

    <div class="w3-row">
        <div class="w3-col w3-container" style="width:20%"></div>
        <div class="w3-col w3-container" style="width:60%">

            <div class="w3-panel w3-light-grey">
                <h1>Polka-php</h1>
                <h3>es fácil, rápido, seguro, gratis y en tú idioma!!!</h3>
                <a class="w3-btn w3-green" href="https://github.com/rotela/polka-php">
                    <span class="fa fa-github"></span> github</a>
                <a class="w3-btn w3-blue" href="https://github.com/rotela/polka-php/wiki">
                    <span class="fa fa-wikipedia-w"></span> wiki</a>
                <br>
                <p></p>
            </div>

            <p>
            Polka-php es un entorno/marco de desarrollo (framework) hecho en y para php. Permite desarrollar aplicaciones web/api mucho más rápido ya que no es necesario empezar desde cero. Polka-php brinda varias herramientas para el desarrollo de aplicaciones web, cuenta con poderosas librerías, ayudantes y varios componentes que hará más placentero escribir código, dejando al desarrollador concentrarse en la lógica de negocio y no en la estructura ya que ésta brinda una estructura básica pero poderosa sobre la cual se puede desarrollar aplicaciones simple o complejas.
            </p>

            <div class="w3-row">
                <div class="w3-col s4">
                    <h4>Características:</h4>
                    <ul class="w3-ul">
                        <li>Arquitectura MVC</li>
                        <li>Modelo de Abstracción de datos</li>
                        <li>Manejador de plantillas</li>
                        <li>Manejos de sesiones</li>
                        <li>Url limpias (amigables)</li>
                        <li>Manejos de formularios</li>
                        <li>Manejos de seguridad</li>
                        <li>Ganchos / Disparadores...</li>
                        <li>Librerías, Ayudantes</li>
                        <li>y muchas otras...</li>
                    </ul>
                </div>

                <div class="w3-col s4">
                    <h4>Soporte para bases de datos:</h4>
                    <ul class="w3-ul">
                        <li>Mysql 4, 5+</li>
                        <li>Firebird</li>
                        <li>PostgreSQL</li>
                        <li>Oracle CAll Interface</li>
                        <li>SQLite 2, 3+</li>
                        <li>ODBC v3</li>
                        <li>Microsoft SQL Server / SQL Azure</li>
                        <li><a href="http://php.net/manual/es/pdo.drivers.php">otros</a></li>
                    </ul>
                </div>

                <div class="w3-col s4">
                    <h4>Es para ti si quieres:</h4>
                    <ul class="w3-ul">
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
        <div class="w3-col w3-container" style="width:20%"></div>
    </div>

    <footer class="w3-row">
        <div class="w3-col w3-container" style="width:20%"></div>
        <div class="w3-col w3-container w3-blue-grey" style="width:60%">
            <p>Estructura de desarrollo, página renderizada en <?= tiempo_fin(); ?> s/ms con <?= memoria_usada(); ?><br><?= ap_titulo() . ' ' . ap_version(); ?> | <?= ap_derechos(); ?></p>
        </div>
        <div class="w3-col w3-container" style="width:20%"></div>
    </footer>

</body>

</html>