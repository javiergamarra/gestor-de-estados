<h1>Listado de artefactos para el proyecto: <?php echo $proyecto ?></h1>

<div>
<table class="listados">
<?php foreach ($artefactos as $i => $artefacto): ?>
	<tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
		<td><?php echo $artefacto->getProyecto() ?></td>
		<td class="especial"><a
			href="<?php echo url_for('artefacto/show?id='.$artefacto->getId().'&proyectoId='.$proyecto->getId()) ?>">
			<?php echo $artefacto->getNombre() ?> </a></td>
		<td><?php echo $artefacto->getTipo() ?></td>
		<td>&nbsp; <a
			href="<?php echo url_for('artefacto/show?id='.$artefacto->getId().'&proyectoId='.$proyecto->getId()) ?>">
		<img title="Consultar artefacto" src="/~javgama/gestor/web/images/filter.png" /></a>

		&nbsp; <?php if(Version::tramitableEstado(Estado::CREADA)):?> <a
			href="<?php echo url_for('version/new?artefactoId='.$artefacto->getId()) ?>"><img
			title="Nueva peticion" src="/~javgama/gestor/web/images/add.png" /></a> <?php endif;?></td>

	</tr>
	<?php endforeach ?>
</table>
</div>
	<?php if($sf_user->hasPermission('usuario') or $sf_user->hasPermission('comite') or $sf_user->hasPermission('administrador')):?>
<div style="float: right;"><?php echo button_to('Nuevo Artefacto', 'artefacto/new?proyectoId='.$proyecto->getId()) ?>
</div>
	<?php endif;?>

