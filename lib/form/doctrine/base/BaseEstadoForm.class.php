<?php

/**
 * Estado form base class.
 *
 * @method Estado getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEstadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'nombre'             => new sfWidgetFormInputText(),
      'descripcion'        => new sfWidgetFormInputText(),
      'fase'               => new sfWidgetFormInputText(),
      'edicion'            => new sfWidgetFormInputCheckbox(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'estados_hijos_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Estado')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'             => new sfValidatorString(array('max_length' => 255)),
      'descripcion'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fase'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'edicion'            => new sfValidatorBoolean(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'estados_hijos_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Estado', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Estado', 'column' => array('nombre')))
    );

    $this->widgetSchema->setNameFormat('estado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Estado';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['estados_hijos_list']))
    {
      $this->setDefault('estados_hijos_list', $this->object->EstadosHijos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveEstadosHijosList($con);

    parent::doSave($con);
  }

  public function saveEstadosHijosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['estados_hijos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->EstadosHijos->getPrimaryKeys();
    $values = $this->getValue('estados_hijos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('EstadosHijos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('EstadosHijos', array_values($link));
    }
  }

}
