<?php

/**
 * Artefacto form base class.
 *
 * @method Artefacto getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseArtefactoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormInputText(),
      'descripcion' => new sfWidgetFormTextarea(),
      'tipo_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tipo'), 'add_empty' => false)),
      'proyecto_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'), 'add_empty' => false)),
      'validado'    => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'version'     => new sfWidgetFormInputText(),
      'padres_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto')),
      'hijos_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 255)),
      'descripcion' => new sfValidatorString(array('max_length' => 4000)),
      'tipo_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tipo'))),
      'proyecto_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'))),
      'validado'    => new sfValidatorBoolean(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'version'     => new sfValidatorInteger(array('required' => false)),
      'padres_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto', 'required' => false)),
      'hijos_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('artefacto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Artefacto';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['padres_list']))
    {
      $this->setDefault('padres_list', $this->object->Padres->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['hijos_list']))
    {
      $this->setDefault('hijos_list', $this->object->Hijos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePadresList($con);
    $this->saveHijosList($con);

    parent::doSave($con);
  }

  public function savePadresList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['padres_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Padres->getPrimaryKeys();
    $values = $this->getValue('padres_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Padres', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Padres', array_values($link));
    }
  }

  public function saveHijosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['hijos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Hijos->getPrimaryKeys();
    $values = $this->getValue('hijos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Hijos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Hijos', array_values($link));
    }
  }

}
