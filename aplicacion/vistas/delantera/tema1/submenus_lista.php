<div class="row">
  <div class="col-md-8">
	<h3>SubMenus</h3>
  </div>
  <div class="col-md-4">
	<a class="btn btn-default btn-sm pull-right" href="<?= base_url('submenus/nuevo'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> nuevo</a>
  </div>
</div>
<?php $alerta = obt_alerta('alerta'); echo $alerta; ?>
<?php echo $paginador; ?>
<hr>
<table class="table table-bordered table-striped table-condensed table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Menu</th>
			<th>Etiqueta</th>
			<th>Url</th>
			<th>Orden</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($submenus as $fila): ?>
	<tr>
		<td><?php echo $fila->idsub; ?></td>
		<td><?php echo $fila->menu_etiqueta; ?></td>
		<td><?php echo $fila->submenu_etiqueta; ?></td>
		<td><?php echo $fila->submenu_url; ?></td>
		<td><?php echo $fila->submenu_ord; ?></td>
		<td>
			<a class="btn btn-success btn-xs" href="<?= base_url('submenus/ver/'.$fila->idsub); ?>">
				<span class="glyphicon glyphicon-eye-open"></span>
			</a>
			<a class="btn btn-warning btn-xs" href="<?= base_url('submenus/editar/'.$fila->idsub); ?>">
				<span class="glyphicon glyphicon-edit"></span>
			</a>
			<a class="btn btn-danger btn-xs" href="<?= base_url('submenus/eliminar/1/'.$fila->idsub); ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>