<?php

/**
 * EstadoHijo form base class.
 *
 * @method EstadoHijo getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEstadoHijoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'padre_id' => new sfWidgetFormInputHidden(),
      'hijo_id'  => new sfWidgetFormInputHidden(),
      'mensaje'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'padre_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('padre_id')), 'empty_value' => $this->getObject()->get('padre_id'), 'required' => false)),
      'hijo_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('hijo_id')), 'empty_value' => $this->getObject()->get('hijo_id'), 'required' => false)),
      'mensaje'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('estado_hijo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EstadoHijo';
  }

}
