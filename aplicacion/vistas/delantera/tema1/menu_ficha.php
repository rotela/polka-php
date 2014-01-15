<!-- alerta -->
<?php $alerta = obt_alerta('alerta'); echo $alerta; ?>
<!-- titulo -->
<h3>Datos del menú</h3>
<hr>
<!-- datos encontrados -->
<?php if (isset($menu)): ?>
<dl class="dl-horizontal">
	<?php foreach ($menu as $key => $value): ?>
	  <dt><?php echo strtoupper($key).':'; ?></dt>
  	  <dd><?php echo $value; ?></dd>
	<?php endforeach; ?>
</dl>
<?php endif; ?>
<hr>
<a class="btn btn-default" href="<?= base_url('menus/listar'); ?>"><i class="glyphicon glyphicon-list"></i> lista</a>