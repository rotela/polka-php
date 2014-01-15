<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?= pk_titulo(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?= vista_css('bootstrap.min.css'); ?>" rel="stylesheet" >
    <link href="<?= vista_css('index.css'); ?>" rel="stylesheet" >
  </head>
  <body>
    <div id="wrap">
		<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="<?= base_url(); ?>"><?= pk_titulo(); ?></a>
		    </div>
		    <div class="collapse navbar-collapse navbar-ex1-collapse">
		      <ul class="nav navbar-nav">
		      	<li><a href="<?= base_url('manual'); ?>"><i class="icon-user"></i> Manual</a></li>
		      	<li><a href="<?= base_url('menus'); ?>"><i class="icon-user"></i> Menus</a></li>
		      	<li><a href="<?= base_url('submenus'); ?>"><i class="icon-user"></i> Submenus</a></li>
		      	<li><a href="<?= base_url('articulos'); ?>"><i class="icon-user"></i> Artículos</a></li>
		      	<li><a href="<?= base_url('seccion'); ?>"><i class="icon-user"></i> Sección</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>
      <div class="container">
      	<!-- principal -->
		<?php echo isset($contenido) ? $contenido : 'sin contenido'; ?>
      </div>
      <div id="push"></div>
    </div>
    <div id="footer">
	  <div class="container">
	    <p class="muted credit pie">Marco de desarrollo | página renderizada en <?= tiempo_fin(); ?> s/ms con <?= memoria_usada(); ?> MB<br>
	    	<?= pk_titulo().' '.pk_version(); ?> | Copyright 2013©</p>
	  </div>
	</div>
    <script src="<?= vista_jq(); ?>"></script>
    <script src="<?= vista_js('bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('aplicacion/vistas/delantera/tema1/ckeditor/ckeditor.js'); ?>"></script>
  </body>
</html>