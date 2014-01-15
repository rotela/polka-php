<!-- categorias -->
<div class="panel panel-default">
	<div class="panel-heading">Secciones</div>
	<?php if (isset($secciones)): ?>
	<div class="list-group">
	<?php foreach ($secciones as $valor): ?>
		<a href="<?= base_url('manual/secciones/'.$valor->seccion_url); ?>" class="list-group-item"><?= $valor->seccion_nombre; ?></a>
	<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>