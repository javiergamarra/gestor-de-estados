<?php use_helper('Text') ?>

<div class="formulario">
<h1><?php echo $proyecto->getNombre() ?></h1>
<h3><?php echo $proyecto->getUrl() ?></h3>

<div class="descripcion"><?php echo simple_format_text($proyecto->getDescripcion()) ?>
</div>

<div class="descripcion">
<table>
	<tr>
		<th style="width:200px">Usuarios asociados</th>

		<td colspan="4">
		<table>
		<?php foreach ($proyecto->getUsers() as $usuario): ?>
			<tr>
				<td colspan="2"><?php echo $usuario?></td>
			</tr>
			<?php endforeach; ?>
		</table>

		<div id="ficheros"></div>
		</td>
	</tr>
</table>
</div>
<div class="meta"><small>created on <?php echo $proyecto->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
</div>

<div style="padding: 20px 0"><a
	href="<?php echo url_for('proyecto/edit?id='.$proyecto->getId()) ?>">
Editar proyecto </a>
<p />
<a href="<?php echo url_for('proyecto/index') ?>">Volver</a></div>
</div>

<hr />

