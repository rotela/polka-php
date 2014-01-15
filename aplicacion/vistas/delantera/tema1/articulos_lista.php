<div class="row">
  <div class="col-md-8">
	<h3>Artículos</h3>
  </div>
  <div class="col-md-4">
	<a class="btn btn-default btn-sm pull-right" href="<?= base_url('articulos/nuevo'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> nuevo</a>
  </div>
</div>
<?php $alerta = obt_alerta('alerta'); echo $alerta; ?>
<?php echo $paginador; ?>
<table class="table table-bordered table-striped table-condensed table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Titulo</th>
			<th>Sección</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($articulos as $fila): ?>
	<tr>
		<td><?= $fila->idart; ?></td>
		<td><?= ancla($fila->titulo,base_url('articulos/ver/'.$fila->titulo_url)); ?></td>
		<td><?= $fila->seccion_nombre; ?></td>
		<td>
			<a class="btn btn-success btn-xs" href="<?= base_url('articulos/previo/'.$fila->idart); ?>">
				<span class="glyphicon glyphicon-eye-open"></span>
			</a>
			<a class="btn btn-warning btn-xs" href="<?= base_url('articulos/editar/'.$fila->idart); ?>">
				<span class="glyphicon glyphicon-edit"></span>
			</a>
			<a class="btn btn-danger btn-xs" href="<?= base_url('articulos/eliminar/1/'.$fila->idart); ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<div class="well">
<?php echo $sql; ?>
</div>