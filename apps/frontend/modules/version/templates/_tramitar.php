<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form
	action="<?php echo url_for('version/'.'publish'.'?id='.$form->getObject()->getId().'&artefactoId='.$form->getObject()->getArtefacto()->getId()) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<input type="hidden" name="sf_method" value="put" />
<table class="form">
	<tbody>

		<tr>
			<th><?php echo $form['nombre']->renderLabel() ?></th>
			<td><?php echo $form['nombre'] ?> <?php echo $form['nombre']->renderError() ?></td>
		</tr>
		<tr>
			<th><?php echo $form['identificador']->renderLabel() ?></th>
			<td><?php echo $form['identificador'] ?> <?php echo $form['identificador']->renderError() ?></td>
		</tr>
		<tr>
			<th><?php echo $form['descripcion']->renderLabel() ?></th>
			<td><?php echo $form['descripcion'] ?> <?php echo $form['descripcion']->renderError() ?></td>
		</tr>
		<tr>
			<th><?php echo $form['tipo_id']->renderLabel() ?></th>
			<td><?php echo $form['tipo_id'] ?> <?php echo $form['tipo_id']->renderError() ?></td>
		</tr>

		<?php if ($form->getObject()->getEstado()->getAsignable()):?>
		<tr>
			<th><?php echo $form['users_list']->renderLabel() ?></th>
			<td><?php echo $form['users_list'] ?> <?php echo $form['users_list']->renderError() ?></td>
		</tr>
		<?php endif;?>
		<?php if ($form->getObject()->getArtefacto()->getPadres()):?>
		<tr>
			<th>Artefactos afectados (relaci&oacute;n parte de)</th>
			<td colspan="4">
			<table>
			<?php foreach ($form->getObject()->getArtefacto()->getPadres() as $artefacto): ?>
				<tr>
					<td colspan="2"><?php echo $artefacto?></td>
				</tr>
				<?php endforeach; ?>
			</table>

			<div id="ficheros"></div>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td colspan="4"><?php foreach ($form as $name => $field): ?> <?php if (isset($form[$name]) && preg_match('/item_pos/', $name)) { ?>
			<table>
				<tr>
					<td><?php echo $form[$name] -> renderLabel() ?></td>
					<td colspan="2"><?php echo $form[$name] ?> <?php echo $form[$name]->renderError() ?></td>
				</tr>
			</table>
			<?php } endforeach; ?>
			<div id="ficheros"></div>
			</td>
		</tr>


		<tr>
			<td colspan="2"><?php echo $form->renderHiddenFields() ?></td>
			<td colspan="2"><?php echo $form->renderGlobalErrors() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"><a
				href="<?php echo url_for('version/index?artefactoId='.$form->getObject()->getArtefacto()->getId()) ?>">Volver
			al listado</a>
			<div style="padding: 10px 0px"><?php foreach ($form->getObject()->getEstado()->getHijos() as $estado): ?>
			<?php if(Version::tramitableEstado($estado->getEstadosHijos()->getNombre())):?>
			<div style="float: right;"><input type="submit"
				value="<?php echo $estado->getTexto() ?>"
				name="<?php echo $estado->getEstadosPadres()->getNombre() ?>" /></div>
				<?php endif;?> <?php endforeach;?></div>
			</td>
		</tr>
	</tfoot>
</table>