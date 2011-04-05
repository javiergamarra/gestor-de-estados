<?php

/**
 * LineasVersion form base class.
 *
 * @method LineasVersion getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLineasVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'linea_base_id' => new sfWidgetFormInputHidden(),
      'version_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'linea_base_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('linea_base_id')), 'empty_value' => $this->getObject()->get('linea_base_id'), 'required' => false)),
      'version_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('version_id')), 'empty_value' => $this->getObject()->get('version_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lineas_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LineasVersion';
  }

}
