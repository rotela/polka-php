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
    $nombre = '';
    $url    = '';
    if(isset($errores['seccion_nombre'])) $estado_nombre = !empty($errores['seccion_nombre']) ? 'has-error' : 'has-success';
    if(isset($errores['seccion_url'])) $seccion_url      = !empty($errores['seccion_url']) ? 'has-error' : 'has-success';
    ?>
    <form class="form-horizontal" role="form" action="<?= base_url('seccion/nueva'); ?>" method="post">
      <fieldset><legend>Nueva Sección</legend>
      <div class="form-group <?= $nombre; ?>">
        <label class="col-lg-4 control-label" for="seccion_nombre">Etiqueta</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="seccion_nombre" id="seccion_nombre" value="<?= obt_valor('seccion_nombre'); ?>" placeholder="Etiqueta">
        </div>
      </div>
      <div class="form-group <?= $url; ?>">
        <label class="col-lg-4 control-label" for="seccion_url">Url</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="seccion_url" id="seccion_url" value="<?= obt_valor('seccion_url'); ?>" placeholder="seccion_url">
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-offset-4 col-lg-8">
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
          <a href="<?= base_url('seccion/listar'); ?>" class="btn btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
        </div>
      </div>
      </fieldset>
    </form>
  </div>
  <div class="col-md-2"></div>
</div>
<br>