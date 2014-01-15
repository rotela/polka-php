<!-- alerta -->
<?php $alerta = obt_alerta('alerta'); echo $alerta; ?>
<!-- titulo -->
<h3>Datos del Artículo</h3>
<hr>
<!-- datos encontrados -->
<?php if (isset($articulo)): ?>
<dl class="dl-horizontal">
	<?php foreach ($articulo as $key => $value): ?>
	  <dt><?php echo strtoupper($key).':'; ?></dt>
  	  <dd><?php echo $value; ?></dd>
	<?php endforeach; ?>
<?php endif; ?>
<hr>
<dt></dt>
<dd>
<a class="btn btn-default" href="<?= base_url('articulos/listar'); ?>"><i class="glyphicon glyphicon-list"></i> lista</a>
<a class="btn btn-default" href="<?= base_url('articulos/editar/'.$articulo->idart); ?>"><i class="glyphicon glyphicon-edit"></i> editar</a>
</dd>
</dl>
<hr>