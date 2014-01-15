<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <?php
    $errores = obt_errores();
    if ($errores):
      foreach ($errores as $value): ?>
      <div class="alert alert-danger alert-dismissable fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error</strong>, <?= $value; ?>
      </div>
    <?php
      endforeach;
    endif;
    $nombre    = '';
    $url       = '';
    $profesion = '';
    if(isset($errores['menu_etiqueta'])) $estado_nombre = !empty($errores['menu_etiqueta']) ? 'has-error' : 'has-success';
    if(isset($errores['menu_url'])) $menu_url           = !empty($errores['menu_url']) ? 'has-error' : 'has-success';
    if(isset($errores['menu_ord'])) $estado_profesion   = !empty($errores['menu_ord']) ? 'has-error' : 'has-success';
    ?>
    <form class="form-horizontal" role="form" action="<?= base_url('menus/nuevo'); ?>" method="post">
      <fieldset><legend>Nuevo Menú</legend>
      <div class="form-group <?= $nombre; ?>">
        <label class="col-lg-4 control-label" for="menu_etiqueta">Etiqueta</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="menu_etiqueta" id="menu_etiqueta" value="<?= obt_valor('menu_etiqueta'); ?>" placeholder="Etiqueta">
        </div>
      </div>
      <div class="form-group <?= $url; ?>">
        <label class="col-lg-4 control-label" for="menu_url">Url</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="menu_url" id="menu_url" value="<?= obt_valor('menu_url'); ?>" placeholder="menu_url">
        </div>
      </div>
      <div class="form-group <?= $orden; ?>">
        <label class="col-lg-4 control-label" for="menu_ord">Orden</label>
        <div class="col-lg-2">
          <input type="number" class="form-control" name="menu_ord" id="menu_ord" value="<?= obt_valor('menu_ord'); ?>" placeholder="menu_ord">
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-offset-4 col-lg-8">
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
          <a href="<?= base_url('menus/listar'); ?>" class="btn btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
        </div>
      </div>

      </fieldset>
    </form>
  </div>
  <div class="col-md-2"></div>
</div>
<br>