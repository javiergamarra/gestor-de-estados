
<?php foreach ($form as $name => $field): ?>
<?php if (isset($form[$name]) && strncmp($name, 'item_pos', 8) == 0) { ?>
<table>
	<tr>
		<th><?php echo $form[$name] -> renderLabel() ?></th>
		<td><?php echo $form[$name] ?> <?php echo $form[$name]->renderError() ?></td>
	</tr>

</table>

<?php } endforeach; ?>
