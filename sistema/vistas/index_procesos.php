<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?= pk_titulo(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo vista_css('bootstrap.min.css'); ?>" rel="stylesheet" >
    <link href="<?php echo vista_css('index.css'); ?>" rel="stylesheet" >
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
		      <a class="navbar-brand" href="<?= url_base(); ?>"><?= pk_titulo(); ?></a>
		    </div>
		    <div class="collapse navbar-collapse navbar-ex1-collapse">
		      <ul class="nav navbar-nav">
		      </ul>
		    </div>
		  </div>
		</nav>
      <div class="container">
      	<?= isset($_contenido) ? $_contenido : 'Contenido vacío.'; ?>
      </div>
      <div id="push"></div>
    </div>
    <div id="footer">
	  <div class="container">
	    <p class="muted credit pie">Marco de desarrollo | página renderizada en <?= tiempo_fin(); ?> s/ms con <?= memoria_usada(); ?> MB<br>
	    	<?= pk_titulo().' '.pk_version(); ?> | Copyright 2014©</p>
	  </div>
	</div>
    <script src="<?php echo vista_jquery(); ?>"></script>
    <script src="<?php echo vista_js('bootstrap.min.js'); ?>"></script>
  </body>
</html>