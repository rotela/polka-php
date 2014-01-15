<div class="row">
  <div class="col-md-8">
	<h3>Menus</h3>
  </div>
  <div class="col-md-4">
	<a class="btn btn-default btn-sm pull-right" href="<?= base_url('menus/nuevo'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> nuevo</a>
  </div>
</div>
<?php $alerta = obt_alerta('alerta'); echo $alerta; ?>
<?php echo $paginador; ?>
<hr>
<table class="table table-bordered table-striped table-condensed table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Etiqueta</th>
			<th>Url</th>
			<th>Orden</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($menus as $fila): ?>
	<tr>
		<td><?php echo $fila->idmen; ?></td>
		<td><?php echo $fila->menu_etiqueta; ?></td>
		<td><?php echo $fila->menu_url; ?></td>
		<td><?php echo $fila->menu_ord; ?></td>
		<td>
			<a class="btn btn-success btn-xs" href="<?= base_url('menus/ver/'.$fila->idmen); ?>">
				<span class="glyphicon glyphicon-eye-open"></span>
			</a>
			<a class="btn btn-warning btn-xs" href="<?= base_url('menus/editar/'.$fila->idmen); ?>">
				<span class="glyphicon glyphicon-edit"></span>
			</a>
			<a class="btn btn-danger btn-xs" href="<?= base_url('menus/eliminar/1/'.$fila->idmen); ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>