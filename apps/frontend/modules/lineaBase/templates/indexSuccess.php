<h1>Listado de lineas bases</h1>

<div>
<table class="listados">
	<tr class="header">
		<td>Id</td>
		<td>Nombre</td>
		<td>Descripcion</td>
		<td>Fecha de creacion</td>
		<td>Acciones</td>
	</tr>
	<?php foreach ($linea_bases as $i => $linea_base): ?>
	<tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
		<td><?php echo $linea_base->getId() ?></td>

		<td class="especial"><a
			href="<?php echo url_for('lineaBase/show?id='.$linea_base->getId().'&proyectoId='.$proyecto->getId()) ?>">
			<?php echo $linea_base->getNombre() ?> </a></td>
		<td><?php echo $linea_base->getDescripcion() ?></td>
		<td><?php echo $linea_base->getDateTimeObject('created_at')->format('m/d/Y') ?></td><td>
		
		<a
			href="<?php echo url_for('lineaBase/show?id='.$linea_base->getId().'&proyectoId='.$proyecto->getId())?>">
		<img title="Consultar linea base" src="/~javgama/gestor/web/images/filter.png" />
		</a>
		</td>
	</tr>
	<?php endforeach ?>
</table>
</div>
	<?php if($sf_user->hasPermission('comite') or $sf_user->hasPermission('administrador')):?>
<div style="float: right;"><?php echo button_to('Nueva Linea Base', 'lineaBase/new?proyectoId='.$proyecto->getId()) ?></div>
	<?php endif;?>