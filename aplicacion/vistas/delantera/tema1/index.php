<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?= ap_titulo(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?= vista_css('bootstrap.min.css'); ?>" rel="stylesheet" >
    <link href="<?= vista_css('index.css'); ?>" rel="stylesheet" >
    <script type="text/javascript" charset="utf-8">
      function url_base(){
        var dominio = '<?= url_base(); ?>';
        return dominio;
      }
    </script>
  </head>
  <body>
    <div id="wrap">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
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
          <?= (isset($navbar)) ? $navbar : vista_capa('navbar'); ?>
        </div>
      </nav>
      <div class="container">
      <?= obt_dato_temp('alerta_index'); ?>
      <?= (isset($contenido)) ? $contenido : vista_capa('principal'); ?>
      </div>
      <div id="push"></div>
    </div>
    <div id="footer">
    <div class="container">
      <p class="muted credit pie">Polka PHP - Marco de desarrollo | página renderizada en <?= tiempo_fin(); ?> s/ms con <?= memoria_usada(); ?> MB<br>
        <?= ap_titulo().' '.ap_version(); ?> | Copyright <?= ap_derechos(); ?></p>
    </div>
  </div>
    <script src="<?= vista_jquery(); ?>"></script>
    <script src="<?= vista_js('bootstrap.min.js'); ?>"></script>
    <script src="<?= vista_js('bootbox.min.js'); ?>"></script>
    <?= obt_arc_js(); ?>
  </body>
</html>