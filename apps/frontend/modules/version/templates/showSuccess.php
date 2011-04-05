<?php use_helper('Text') ?>

<div class="formulario">
<h1><?php echo $version->getNombre() ?></h1>
<h2><?php echo $version->getArtefacto() ?></h2>

<h3>Estado de la solicitud de cambio:  <?php echo $version->getEstado() ?></h3>
<div class="descripcion"><?php echo simple_format_text($version->getDescripcion()) ?>
</div>
<div class="descripcion">
<table>
	<tr>
		<th style="width: 200px">Usuarios asociados</th>

		<td colspan="4">
		<table>
		<?php foreach ($version->getUsers() as $usuario): ?>
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
			<?php
			$aux_fich = $version->getFicheros();
			if (sizeof($aux_fich) != 0){ ?>
<div class="descripcion">
<table class="form">
	<tr>
		<th><span>'Ficheros'</span></th>
		<td>
		<ul>
		<?php foreach ($aux_fich as $i => $fichero):
		if($fichero->getNombre() != null){ ?>
			<li><?php 

			$vector = explode(".", $fichero->getFile());
			$extension = $vector[count($vector)-1];
			$extension = strtolower($extension);


			switch($extension) {
				case "gif": echo '<img alt="'.$fichero->getDescripcion().'" width="400px" src='.url_for('version/descarga?fichero='.$fichero->getFile()).'/>'; break;
				case "jpg": echo '<img alt="'.$fichero->getDescripcion().'" width="400px" src='.url_for('version/descarga?fichero='.$fichero->getFile()).'/>'; break;
			}
			?> <a
				href="<?php echo url_for('version/descarga?fichero='.$fichero->getFile()) ?>"><?php echo $fichero->getNombre() ?></a>
			</li>
			<?php }
			endforeach; ?>
		</ul>
		</td>
	</tr>
</table>
</div>
			<?php } ?>

<div class="meta"><small>creado en <?php echo $version->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
</div>

<div style="padding: 20px 0"><a
	href="<?php echo url_for('version/index?artefactoId='.$version->getArtefacto()->getId()) ?>">Volver</a>
</div>

</div>
<hr />
