<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form
	action="<?php echo url_for('proyecto/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> <input type="hidden"
	name="sf_method" value="put" /> <?php endif; ?>
<table class="form">

	<tbody>
	<?php echo $form ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">&nbsp;<a
				href="<?php echo url_for('proyecto/index') ?>">Volver al listado</a>

			<div style="float: right;"><input type="submit" value="Guardar" /></div>
			</td>
		</tr>
	</tfoot>


</table>
</form>
