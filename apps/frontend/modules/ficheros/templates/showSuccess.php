<table>
	<tbody>
		<tr>
			<th>Id:</th>
			<td><?php echo $ficheros->getid() ?></td>
		</tr>
		<tr>
			<th>Nombre:</th>
			<td><?php echo $ficheros->getnombre() ?></td>
		</tr>
		<tr>
			<th>Ruta:</th>
			<td><?php echo $ficheros->getruta() ?></td>
		</tr>
		<tr>
			<th>Version:</th>
			<td><?php echo $ficheros->getVersionId() ?></td>
		</tr>
		<tr>
			<th>Descripcion:</th>
			<td><?php echo $ficheros->getdescripcion() ?></td>
		</tr>
	</tbody>
</table>

<hr />

<a href="<?php echo url_for('ficheros/edit?id='.$ficheros->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('ficheros/index') ?>">List</a>
