

<h1>Listado de solicitudes de cambios <?php echo ($artefacto) ?  ' para el '.$artefacto : ''?></h1>
<h1><?php if ($pendientes): echo 'PENDIENTES DE TRAMITE'; endif;?></h1>
<div>
<table class="listados">
	<tr class="header">
		<td>Proyecto</td>
		<td>Artefacto</td>
		<td>Nombre</td>
		<td>Fecha</td>
		<td>Estado</td>
		<td>Acciones</td>
	</tr>
	<?php foreach ($versions as $i => $version): ?>
	<tr
		class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?> <?php echo $version->getValidada() ? 'green' : '' ?>">
		<td><?php echo $version->getArtefacto()->getProyecto() ?></td>
		<td><?php echo $version->getArtefacto() ?></td>
		<td class="especial"><a
			href="<?php echo url_for('version/show?id='.$version->getId().'&artefactoId='.$version->getArtefacto()->getId()) ?>">
			<?php echo $version->getNombre() ?> </a></td>
		<td><?php echo $version->getDateTimeObject('updated_at')->format('m/d/Y') ?></td>
		<td><?php echo $version->getEstado() ?></td>

		<td style="width:100px;">
		<a
			href="<?php echo url_for('version/show?id='.$version->getId().'&artefactoId='.$version->getArtefacto()->getId()) ?>">
		<img title="Consultar peticion" src="/~javgama/gestor/web/images/filter.png" /></a>
		
			&nbsp;
			
			<?php if($version->tramitable()):?> <a
			href="<?php echo url_for('version/tramitar?id='.$version->getId().'&artefactoId='.$version->getArtefacto()->getId()) ?>">
		Tramitar </a> <?php endif;?></td>
	</tr>
	<?php endforeach ?>
</table>
</div>
	<?php if(Version::tramitableEstado(Estado::CREADA)):?>
	<?php if ($artefacto):?>
<div style="float: right"><?php echo button_to('Nueva solicitud de cambios', 'version/new?artefactoId='.$artefacto->getId()) ?></div>
	<?php endif;?>
	<?php endif;?>