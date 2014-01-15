<div class="row">
  <div class="col-md-8">
	<h3>Usuarios</h3>
  </div>
  <div class="col-md-4">
	<a class="btn btn-default btn-sm pull-right" href="<?= base_url('usuarios/nuevo'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> nuevo</a>
  </div>
</div>
<?php
$alerta = obt_alerta('alerta');
echo $alerta;
?>
<p><?php echo $paginador; ?></p>
<hr>
<table class="table table-bordered table-striped table-condensed table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Edad</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($usuarios as $fila): ?>
	<tr>
		<td><?php echo $fila->idusu; ?></td>
		<td><?php echo $fila->nombre; ?></td>
		<td><?php echo $fila->edad; ?></td>
		<td>
			<a class="btn btn-success btn-xs" href="<?php echo base_url('usuarios/ver/'.$fila->idusu); ?>">
				<span class="glyphicon glyphicon-eye-open"></span>
			</a>
			<a class="btn btn-warning btn-xs" href="<?php echo base_url('usuarios/editar/'.$fila->idusu); ?>">
				<span class="glyphicon glyphicon-edit"></span>
			</a>
			<a class="btn btn-danger btn-xs" href="<?php echo base_url('usuarios/eliminar/1/'.$fila->idusu); ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>