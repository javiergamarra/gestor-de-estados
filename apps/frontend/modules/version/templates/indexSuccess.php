<?php
include_partial('index', array('versions' => $versions,'artefacto' => $artefacto,'pendientes' => $pendientes));
?>

<?php if($artefacto != null):?>
<a
	href="<?php echo url_for('artefacto/show?id='.$artefacto->getId().'&proyectoId='.$artefacto->getProyecto()->getId()) ?>">Volver
al artefacto</a>
<?php endif ?>
