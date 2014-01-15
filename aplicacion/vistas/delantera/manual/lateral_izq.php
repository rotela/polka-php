<!-- articulos -->
<?php if (isset($articulos)): ?>
<div class="panel panel-default">
	<div class="panel-heading">Artículos</div>
	<div class="list-group">
	<?php foreach ($articulos as $valor): ?>
		<a href="<?= base_url('manual/secciones/'.$valor->seccion_url.'/'.$valor->titulo_url); ?>" class="list-group-item"><?= $valor->titulo; ?></a>
	<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>