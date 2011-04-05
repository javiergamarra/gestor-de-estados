<?php use_helper('Text') ?>

<div class="formulario">
<h1><?php echo $linea_base->getNombre() ?></h1>
<h2><?php echo $linea_base->getId() ?></h2>
<h3><?php echo $linea_base->getProyecto() ?></h3>
<div class="descripcion"><?php echo simple_format_text($linea_base->getDescripcion()) ?>
</div>

<div class="meta"><small>created on <?php echo $linea_base->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
</div>
<table class="form">
	<tr>
		<td>Versiones asociadas</td>
		<td colspan="3"><?php foreach ($linea_base->getVersiones() as $version): ?>
		<table>
			<tr>
				<td><?php echo $version->getArtefacto() ?></td>
				<td><?php echo $version->getNombre() ?></td>
				<td><?php echo $version->getDescripcion() ?></td>
			</tr>
		</table>
		<?php  endforeach; ?>
		<div id="ficheros"></div>
		</td>
	</tr>
</table>
<div style="padding: 20px 0"><a
	href="<?php echo url_for('lineaBase/edit?id='.$linea_base->getId().'&proyectoId='.$linea_base->getProyecto()->getId()) ?>">
Editar l&iacute;nea base </a>
<p />
<a
	href="<?php echo url_for('lineaBase/index?proyectoId='.$linea_base->getProyectoId())?>">Volver</a></div>
</div>

<hr />
