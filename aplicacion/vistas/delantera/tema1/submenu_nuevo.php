<div class="row">
  <div class="col-md-6 col-md-offset-3">
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
    $e_idmen    = '';
    $e_etiqueta = '';
    $e_url      = '';
    $e_orden    = '';
    if(isset($errores['idmen'])) $e_idmen               = !empty($errores['idmen']) ? 'has-error' : 'has-success';
    if(isset($errores['submenu_etiqueta'])) $e_etiqueta = !empty($errores['submenu_etiqueta']) ? 'has-error' : 'has-success';
    if(isset($errores['submenu_url'])) $e_url           = !empty($errores['submenu_url']) ? 'has-error' : 'has-success';
    if(isset($errores['submenu_ord'])) $e_orden         = !empty($errores['submenu_ord']) ? 'has-error' : 'has-success';
    ?>
    <form class="form-horizontal" role="form" action="<?= base_url('submenus/nuevo'); ?>" method="post">
      <fieldset><legend>Nuevo Submenú</legend>
      <div class="form-group <?= $e_idmen; ?>">
        <label class="col-lg-4 control-label" for="idmen">Menú</label>
        <div class="col-lg-5">
        <?= agr_selector('idmen',$menus,'idmen','','class="form-control"'); ?>
        </div>
      </div>
      <div class="form-group <?= $e_etiqueta; ?>">
        <label class="col-lg-4 control-label" for="submenu_etiqueta">Etiqueta</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="submenu_etiqueta" id="submenu_etiqueta" value="<?= obt_valor('submenu_etiqueta'); ?>" placeholder="Etiqueta">
        </div>
      </div>
      <div class="form-group <?= $e_url; ?>">
        <label class="col-lg-4 control-label" for="submenu_url">Url</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="submenu_url" id="submenu_url" value="<?= obt_valor('submenu_url'); ?>" placeholder="Url">
        </div>
      </div>
      <div class="form-group <?= $e_orden; ?>">
        <label class="col-lg-4 control-label" for="submenu_ord">Orden</label>
        <div class="col-lg-2">
          <input type="number" class="form-control" name="submenu_ord" id="submenu_ord" value="<?= obt_valor('submenu_ord'); ?>" >
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-offset-4 col-lg-8">
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
          <a href="<?= base_url('submenus/listar'); ?>" class="btn btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
        </div>
      </div>

      </fieldset>
    </form>
  </div>
</div>
<br>