<?php

/**
 * Relaciones form base class.
 *
 * @method Relaciones getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRelacionesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'padre_id' => new sfWidgetFormInputHidden(),
      'hijo_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'padre_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('padre_id')), 'empty_value' => $this->getObject()->get('padre_id'), 'required' => false)),
      'hijo_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('hijo_id')), 'empty_value' => $this->getObject()->get('hijo_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('relaciones[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Relaciones';
  }

}
