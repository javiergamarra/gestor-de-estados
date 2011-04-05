<h1>Tramitando la solicitud de cambio del artefacto  <?php echo $form->getObject()->getArtefacto()?></h1>
<h2 class="header">Estado <?php echo $form->getObject()->getEstado()?></h2>
<?php include_partial('tramitar', array('form' => $form)) ?>