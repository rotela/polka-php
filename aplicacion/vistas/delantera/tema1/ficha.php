<!-- alerta -->
<?php
$alerta = obt_alerta('alerta');
echo $alerta;
?>
<!-- titulo -->
<h3>Datos recibidos</h3>
<hr>
<!-- datos encontrados -->
<?php if (isset($usuario)): ?>
<dl class="dl-horizontal">
	<?php foreach ($usuario as $key => $value): ?>
	  <dt><?php echo strtoupper($key).':'; ?></dt>
  	  <dd><?php echo $value; ?></dd>
	<?php endforeach; ?>
</dl>
<?php endif; ?>
<hr>
<a class="btn btn-default" href="<?= base_url('usuarios/listar'); ?>"><i class="glyphicon glyphicon-list"></i> lista</a>