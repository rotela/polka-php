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
$e_titulo     = '';
$e_titulo_url = '';
$e_contenido  = '';
$e_tags       = '';
if(isset($errores['titulo'])) $e_titulo         = !empty($errores['titulo']) ? 'has-error' : 'has-success';
if(isset($errores['titulo_url'])) $e_titulo_url = !empty($errores['titulo_url']) ? 'has-error' : 'has-success';
if(isset($errores['contenido'])) $e_contenido   = !empty($errores['contenido']) ? 'has-error' : 'has-success';
if(isset($errores['tags'])) $e_tags             = !empty($errores['tags']) ? 'has-error' : 'has-success';
?>
<form class="form-horizontal" role="form" action="<?= base_url('articulos/editar/'.$idart); ?>" method="post">

  <div class="form-group">
    <label class="col-lg-3 control-label" for="idsec">Sección</label>
    <div class="col-lg-9">
    <?= agr_selector('idsec',$secciones,'idsec',$idsec,'class="form-control"'); ?>
    </div>
  </div>

  <div class="form-group <?= $e_titulo; ?>">
    <label class="col-lg-3 control-label" for="titulo">Título</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="titulo" id="titulo" value="<?= obt_valor('titulo',$titulo); ?>" placeholder="Título">
    </div>
  </div>

  <div class="form-group <?= $e_titulo_url; ?>">
    <label class="col-lg-3 control-label" for="titulo_url">Url</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="titulo_url" id="titulo_url" value="<?= obt_valor('titulo_url',$titulo_url); ?>" placeholder="Url">
    </div>
  </div>

  <div class="form-group <?= $e_contenido; ?>">
    <label class="col-lg-3 control-label" for="titulo">Contenido</label>
    <div class="col-lg-9">
      <textarea class="ckeditor" name="contenido" id="contenido"><?= obt_valor('contenido',$contenido); ?></textarea>
    </div>
  </div>

  <div class="form-group <?= $e_tags; ?>">
    <label class="col-lg-3 control-label" for="tags">Tags</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="tags" id="tags" value="<?= obt_valor('tags',$tags); ?>" placeholder="menu_url">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
      <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
      <a href="<?= base_url('articulos/listar'); ?>" class="btn btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
    </div>
  </div>

</form>