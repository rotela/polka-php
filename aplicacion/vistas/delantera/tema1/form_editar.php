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
    $estado_nombre    = 'has-success';
    $estado_edad      = 'has-success';
    $estado_profesion = 'has-success';
    if(isset($errores['nombre'])) $estado_nombre       = !empty($errores['nombre']) ? 'has-error' : 'has-success';
    if(isset($errores['edad'])) $estado_edad           = !empty($errores['edad']) ? 'has-error' : 'has-success';
    if(isset($errores['profesion'])) $estado_profesion = !empty($errores['profesion']) ? 'has-error' : 'has-success';
    ?>
    <form class="form-horizontal" role="form" action="<?= base_url('usuarios/editar/'.$idusu); ?>" method="post">
      <input type="hidden" name="idusu" id="idusu" value="<?= obt_valor('idusu',$idusu); ?>">
      <div class="form-group <?= $estado_nombre; ?>">
        <label class="col-lg-4 control-label" for="nombre">Nombre</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="nombre" id="nombre" value="<?= obt_valor('nombre',$nombre); ?>" placeholder="nombre">
        </div>
      </div>
      <div class="form-group <?= $estado_edad; ?>">
        <label class="col-lg-4 control-label" for="edad">Edad</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="edad" id="edad" value="<?= obt_valor('edad',$edad); ?>" placeholder="edad">
        </div>
      </div>
      <div class="form-group <?= $estado_profesion; ?>">
        <label class="col-lg-4 control-label" for="profesion">Profesión</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" name="profesion" id="profesion" value="<?= obt_valor('profesion',$profesion); ?>" placeholder="profesion">
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-offset-4 col-lg-8">
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Editar</button>
          <a href="<?= base_url('usuarios/lista'); ?>" class="btn btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
        </div>
      </div>

    </form>
  </div>
  <div class="col-md-2"></div>
</div>
<br>