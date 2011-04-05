<?php

/**
 * AsignacionTrabajadoresArt form base class.
 *
 * @method AsignacionTrabajadoresArt getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAsignacionTrabajadoresArtForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'      => new sfWidgetFormInputHidden(),
      'artefacto_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'artefacto_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('artefacto_id')), 'empty_value' => $this->getObject()->get('artefacto_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asignacion_trabajadores_art[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsignacionTrabajadoresArt';
  }

}
