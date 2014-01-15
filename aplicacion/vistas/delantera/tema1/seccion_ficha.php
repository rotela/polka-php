<!-- alerta -->
<?php $alerta = obt_alerta('alerta'); echo $alerta; ?>
<!-- titulo -->
<h3>Datos de la sección</h3>
<hr>
<!-- datos encontrados -->
<?php if (isset($seccion)): ?>
<dl class="dl-horizontal">
	<?php foreach ($seccion as $key => $value): ?>
	  <dt><?php echo strtoupper($key).':'; ?></dt>
  	  <dd><?php echo $value; ?></dd>
	<?php endforeach; ?>
</dl>
<?php endif; ?>
<hr>
<a class="btn btn-default" href="<?= base_url('seccion/listar'); ?>"><i class="glyphicon glyphicon-list"></i> lista</a>