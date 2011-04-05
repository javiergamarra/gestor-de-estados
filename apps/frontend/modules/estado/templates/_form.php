<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form
	action="<?php echo url_for('estado/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> <input type="hidden"
	name="sf_method" value="put" /> <?php endif; ?>
<table class="form">
	<tfoot>
		<tr>
			<td colspan="2">&nbsp;<a href="<?php echo url_for('estado/index') ?>">Volver al listado</a> 
	<div style="float: right;"><input type="submit" value="Guardar" /></div>		
	
	<?php if (!$form->getObject()->isNew()): ?>
			<div style="float: right;"><?php echo button_to('Delete', 'estado/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</div>
			<?php endif; ?>

			


			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php echo $form ?>
	</tbody>
</table>
</form>
