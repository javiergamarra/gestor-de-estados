<?php

/**
 * AsignacionProyectos form base class.
 *
 * @method AsignacionProyectos getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAsignacionProyectosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'     => new sfWidgetFormInputHidden(),
      'proyecto_Id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'proyecto_Id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('proyecto_Id')), 'empty_value' => $this->getObject()->get('proyecto_Id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asignacion_proyectos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsignacionProyectos';
  }

}
