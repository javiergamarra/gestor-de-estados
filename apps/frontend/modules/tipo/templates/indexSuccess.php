<h1>Listado de tipos</h1>

<div>
<table class="listados">
<?php foreach ($tipos as $i => $tipo): ?>
	<tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
		<td><?php echo $tipo->getId() ?></td>
		<td class="especial"><a
			href="<?php echo url_for('tipo/show?id='.$tipo->getId()) ?>">
			<?php echo $tipo->getNombre() ?> </a></td>
	</tr>
	<?php endforeach ?>
</table>
</div>
<div style="float: right;"><?php echo button_to('Nuevo
Tipo', 'tipo/new') ?></div>
