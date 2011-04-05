<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form
	action="<?php echo url_for('ficheros/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> <input type="hidden"
	name="sf_method" value="put" /> <?php endif; ?>
<table>
	<tfoot>
		<tr>
			<td colspan="2">&nbsp;<a
				href="<?php echo url_for('ficheros/index') ?>" class="boton">Cancelar</a>
				<?php if (!$form->getObject()->isNew()): ?> &nbsp;<?php echo link_to('Borrar', 'ficheros/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'class' => 'boton')) ?>
				<?php endif; ?> <input class="boton" type="submit" value="Guardar" />
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php echo $form ?>
	</tbody>
</table>
</form>
