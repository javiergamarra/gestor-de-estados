<?php use_helper('Text') ?>
 
<div class="formulario">
  <h1><?php echo $estado ?></h1>
  <h2>
    <?php echo $estado->getId() ?>
  </h2>
  <h3>
    <?php echo $estado->getFase() ?>
  </h3>
 
  <div class="meta">
    <small>created on <?php echo $estado->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
  </div>
 
  <div style="padding: 20px 0">
    <a href="<?php echo url_for('estado/edit?id='.$estado->getId()) ?>">
      Editar estado
    </a>
    <p/>
    <a href="<?php echo url_for('estado/index') ?>">Volver</a>
  </div>
</div>

<hr />