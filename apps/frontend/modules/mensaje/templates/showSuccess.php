<?php use_helper('Text') ?>

<div class="formulario">
<h1><?php echo $mensaje->getNombre() ?></h1>
<h2><?php echo $mensaje->getId() ?></h2>

<div class="descripcion"><?php echo simple_format_text($mensaje->getDescripcion()) ?>
</div>
<div class="meta"><small>creado en <?php echo $mensaje->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
</div>


<hr />

<div><a
	href="<?php echo url_for('mensaje/index')?>">Volver</a></div>
</div>
