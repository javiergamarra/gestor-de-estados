<?php

/**
 * Version form base class.
 *
 * @method Version getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nombre'           => new sfWidgetFormInputText(),
      'identificador'    => new sfWidgetFormInputText(),
      'descripcion'      => new sfWidgetFormTextarea(),
      'tipo_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tipo'), 'add_empty' => false)),
      'estado_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Estado'), 'add_empty' => false)),
      'artefacto_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Artefacto'), 'add_empty' => false)),
      'validada'         => new sfWidgetFormInputCheckbox(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'version'          => new sfWidgetFormInputText(),
      'users_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'lineas_base_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LineaBase')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 255)),
      'identificador'    => new sfValidatorInteger(),
      'descripcion'      => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'tipo_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tipo'))),
      'estado_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Estado'))),
      'artefacto_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Artefacto'))),
      'validada'         => new sfValidatorBoolean(),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'version'          => new sfValidatorInteger(array('required' => false)),
      'users_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'lineas_base_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LineaBase', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Version';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['users_list']))
    {
      $this->setDefault('users_list', $this->object->Users->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['lineas_base_list']))
    {
      $this->setDefault('lineas_base_list', $this->object->LineasBase->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveUsersList($con);
    $this->saveLineasBaseList($con);

    parent::doSave($con);
  }

  public function saveUsersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['users_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Users->getPrimaryKeys();
    $values = $this->getValue('users_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Users', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Users', array_values($link));
    }
  }

  public function saveLineasBaseList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['lineas_base_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->LineasBase->getPrimaryKeys();
    $values = $this->getValue('lineas_base_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('LineasBase', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('LineasBase', array_values($link));
    }
  }

}
