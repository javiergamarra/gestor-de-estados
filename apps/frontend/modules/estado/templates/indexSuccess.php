<h1>Listado de estados</h1>

<div>
<table class="listados">
<?php foreach ($estados as $i => $estado): ?>
	<tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
		<td><?php echo $estado->getId() ?></td>
		<td class="especial"><a
			href="<?php echo url_for('estado/show?id='.$estado->getId()) ?>"> <?php echo $estado->getDescripcion() ?>
		</a></td>
		<td><?php echo $estado->getFase() ?></td>
	</tr>
	<?php endforeach ?>
</table>
</div>

<div style="float: right;"><?php echo button_to('Nuevo
Estado', 'estado/new') ?></div>
