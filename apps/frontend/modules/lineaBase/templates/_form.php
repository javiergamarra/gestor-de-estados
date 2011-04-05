<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form
	action="<?php echo url_for('lineaBase/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> <input type="hidden"
	name="sf_method" value="put" /> <?php endif; ?>
<table class="form">
	<tfoot>
		<tr>
			<td colspan="2">

			<div style="float: right;"><input type="submit" value="Guardar" /></div>
			<a
				href="<?php echo url_for('lineaBase/index?proyectoId='.$form->getObject()->getProyecto()->getId()) ?>">Volver al listado</a></td>

		</tr>
	</tfoot>
	<tbody>
	<?php echo $form ?>
		<tr>
			<td colspan="4"><?php foreach ($form->getObject()->getProyecto()->getProyecto() as $artefacto): ?>
			<table>
				<tr>
					<td><?php echo $artefacto ?></td>
					<td colspan="3">
					<table>
					<?php foreach ($artefacto->getVersionesValidadas() as $version): ?>
						<tr>
							<td><?php echo $version->getNombre().'... '?></td>
							<td><input type="radio" name="<?php echo $artefacto->getId() ?>"
								value="<?php echo $version->getId()?>" /></td>
						</tr>
						<?php endforeach;?>
					</table>
					</td>
				</tr>
			</table>
			<?php  endforeach; ?>
			<div id="ficheros"></div>
			</td>
		</tr>

		<tr>
			<td>Versiones asociadas</td>
			<td colspan="3"><?php foreach ($form->getObject()->getVersiones() as $version): ?>
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
	</tbody>
</table>
</form>
