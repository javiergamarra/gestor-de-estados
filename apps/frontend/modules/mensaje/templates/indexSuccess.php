<h1>Listado de mensajes</h1>


<div>
<table class="listados">
	<tr class="header">
		<td>Id</td>
		<td>Nombre</td>
		<td>Descripci&oacute;n</td>
		<td>Fecha</td>
		<td></td>
	</tr>
	<?php foreach ($mensajes  as $i => $mensaje): ?>
	<tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
		<td><?php echo $mensaje->getId() ?></td>
		<td class="especial"><a
			href="<?php echo url_for('mensaje/show?id='.$mensaje->getId()) ?>"> <?php echo $mensaje->getNombre() ?>
		</a></td>
		<td><?php echo $mensaje->getDescripcion() ?></td>
		<td><?php echo $mensaje->getCreatedAt() ?></td>
	</tr>
	<?php endforeach ?>
</table>
</div>
