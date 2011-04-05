<?php use_helper('Text') ?>
 
<div class="formulario">
  <h1><?php echo $tipo ?></h1>
  <h2>
    <?php echo $tipo->getId() ?>
  </h2>
 
  <div class="meta">
    <small>created on <?php echo $tipo->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
  </div>
 
  <div style="padding: 20px 0">
    <a href="<?php echo url_for('tipo/edit?id='.$tipo->getId()) ?>">
      Editar tipo
    </a>
    <p/>
    <a href="<?php echo url_for('tipo/index') ?>">Volver</a>
  </div>
</div>

<hr />