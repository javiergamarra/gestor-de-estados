<h1>Listado de Proyectos</h1>

<div>
<table class="listados">
	<tr class="header">
		<td>Nombre</td>
		<td>URL</td>
		<td>L&iacute;neas base</td>
		<td>Acciones</td>
	</tr>
	<?php foreach ($proyectos as $i => $proyecto): ?>
	<tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
		<td><?php echo $proyecto->getNombre() ?></td>
		<td class="especial"><a
			href="<?php echo url_for('proyecto/show?id='.$proyecto->getId()) ?>">
			<?php echo $proyecto->getUrl() ?> </a></td>
		<td class="especial"><a
			href="<?php echo url_for('lineaBase/index?proyectoId='.$proyecto->getId()) ?>">L&iacute;neas
		base</a></td>
		<td><a
			href="<?php echo url_for('proyecto/show?id='.$proyecto->getId())?>">
		<img title="Consultar proyecto" src="/~javgama/gestor/web/images/filter.png" />
		</a>
		&nbsp;
		<a
			href="<?php echo url_for('artefacto/index?proyectoId='.$proyecto->getId()) ?>"><img
			title="Nuevo artefacto" src="/~javgama/gestor/web/images/add.png" /></a></td>

	</tr>
	<?php endforeach ?>
</table>
</div>
	<?php if($sf_user->hasPermission('comite') or $sf_user->hasPermission('administrador')):?>
<div style="float: right;"><?php echo button_to('Nuevo Proyecto', 'proyecto/new') ?></div>
	<?php endif;?>
