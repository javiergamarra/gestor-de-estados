<?php use_helper('Text') ?>

<div class="formulario">
<h1><?php echo $artefacto->getNombre() ?></h1>

<h4>Validado: <?php if($artefacto->getValidado()) { echo 'VALIDADO'; } else { echo 'SIN VALIDAR'; }?></h4>
<h4>Tipo: <?php echo $artefacto->getTipo() ?></h4>
<div class="descripcion">Descripci&oacute;n: <?php echo simple_format_text($artefacto->getDescripcion()) ?>
</div>

<?php
$aux_fich = $artefacto->getFicheros();
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
<?php } ?> <?php include_partial('version/index', array('versions' => $artefacto->getVersionesValidadas(),'artefacto' => $artefacto,'pendientes' => false)) ?>




<div style="padding: 50px 0">
<div class="meta"><small>creado en <?php echo $artefacto->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
</div>
<div style="padding: 20px 0">

<div style="float: right"><?php echo button_to('Editar artefacto', 'artefacto/edit?id='.$artefacto->getId().'&proyectoId='.$artefacto->getProyecto()->getId()) ?></div>
<?php if(!$artefacto->getValidado()):?>
<div style="float: right"><?php echo button_to('Validar artefacto', 'artefacto/validar?id='.$artefacto->getId().'&proyectoId='.$artefacto->getProyecto()->getId()) ?></div>
<?php endif;?> <a
	href="<?php echo url_for('artefacto/index?proyectoId='.$artefacto->getProyecto()->getId()) ?>">Volver</a></div>
</div>

<hr />