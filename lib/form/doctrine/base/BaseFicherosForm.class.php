<?php

/**
 * Ficheros form base class.
 *
 * @method Ficheros getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFicherosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormInputText(),
      'file'        => new sfWidgetFormInputText(),
      'versionid'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Version'), 'add_empty' => false)),
      'descripcion' => new sfWidgetFormInputText(),
      'deleted'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'file'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'versionid'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Version'))),
      'descripcion' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'deleted'     => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ficheros[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ficheros';
  }

}
