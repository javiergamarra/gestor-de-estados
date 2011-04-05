<h1>Ficheros List</h1>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Nombre</th>
			<th>Ruta</th>
			<th>Version</th>
			<th>Descripcion</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($ficheros_list as $ficheros): ?>
		<tr>
			<td><a
				href="<?php echo url_for('ficheros/show?id='.$ficheros->getId()) ?>"><?php echo $ficheros->getId() ?></a></td>
			<td><?php echo $ficheros->getNombre() ?></td>
			<td><?php echo $ficheros->getRuta() ?></td>
			<td><?php echo $ficheros->getVersionId() ?></td>
			<td><?php echo $ficheros->getDescripcion() ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo url_for('ficheros/new') ?>">New</a>
