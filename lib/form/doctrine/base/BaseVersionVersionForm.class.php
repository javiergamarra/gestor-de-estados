<?php

/**
 * VersionVersion form base class.
 *
 * @method VersionVersion getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVersionVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'nombre'        => new sfWidgetFormInputText(),
      'identificador' => new sfWidgetFormInputText(),
      'descripcion'   => new sfWidgetFormTextarea(),
      'tipo_id'       => new sfWidgetFormInputText(),
      'estado_id'     => new sfWidgetFormInputText(),
      'artefacto_id'  => new sfWidgetFormInputText(),
      'validada'      => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'version'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'        => new sfValidatorString(array('max_length' => 255)),
      'identificador' => new sfValidatorInteger(),
      'descripcion'   => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'tipo_id'       => new sfValidatorInteger(),
      'estado_id'     => new sfValidatorInteger(),
      'artefacto_id'  => new sfValidatorInteger(),
      'validada'      => new sfValidatorBoolean(),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'version'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('version')), 'empty_value' => $this->getObject()->get('version'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('version_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VersionVersion';
  }

}
