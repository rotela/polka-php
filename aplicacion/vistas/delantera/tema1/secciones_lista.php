<div class="row">
  <div class="col-md-8">
	<h3>Secciones</h3>
  </div>
  <div class="col-md-4">
	<a class="btn btn-default btn-sm pull-right" href="<?= base_url('seccion/nueva'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> nuevo</a>
  </div>
</div>
<?php $alerta = obt_alerta('alerta'); echo $alerta; ?>
<?php echo $paginador; ?>
<hr>
<table class="table table-bordered table-striped table-condensed table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Url</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($seccion as $fila): ?>
	<tr>
		<td><?php echo $fila->idsec; ?></td>
		<td><?php echo $fila->seccion_nombre; ?></td>
		<td><?php echo $fila->seccion_url; ?></td>
		<td>
			<a class="btn btn-success btn-xs" href="<?= base_url('seccion/ver/'.$fila->idsec); ?>">
				<span class="glyphicon glyphicon-eye-open"></span>
			</a>
			<a class="btn btn-warning btn-xs" href="<?= base_url('seccion/editar/'.$fila->idsec); ?>">
				<span class="glyphicon glyphicon-edit"></span>
			</a>
			<a class="btn btn-danger btn-xs" href="<?= base_url('seccion/eliminar/1/'.$fila->idsec); ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>