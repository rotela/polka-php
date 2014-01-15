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
      <?= vista_capa('index_barra'); ?>
      <div class="container">
		<div class="row">
      <!-- IZQUIERDO -->
			<div class="col-md-8">
        <?= isset($navegante) ? $navegante : ''; ?>
        <?= isset($contenido) ? $contenido : 'Contenido vacío.'; ?>
      </div>
      <!-- DERECHO -->
			<div class="col-md-4">
        <?= isset($lateral_der) ? $lateral_der : 'menú lateral vacío.'; ?>
      </div>
		</div>
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
  </body>
</html>