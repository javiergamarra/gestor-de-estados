<?php

/**
 * Usuario form base class.
 *
 * @method Usuario getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'email'           => new sfWidgetFormInputText(),
      'nombre'          => new sfWidgetFormInputText(),
      'apellido1'       => new sfWidgetFormInputText(),
      'apellido2'       => new sfWidgetFormInputText(),
      'rol_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rol'), 'add_empty' => false)),
      'asignaciones_id' => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'proyectos_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Proyecto')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'email'           => new sfValidatorString(array('max_length' => 255)),
      'nombre'          => new sfValidatorString(array('max_length' => 255)),
      'apellido1'       => new sfValidatorString(array('max_length' => 255)),
      'apellido2'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'rol_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Rol'))),
      'asignaciones_id' => new sfValidatorInteger(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'proyectos_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Proyecto', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Usuario', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['proyectos_list']))
    {
      $this->setDefault('proyectos_list', $this->object->Proyectos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveProyectosList($con);

    parent::doSave($con);
  }

  public function saveProyectosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['proyectos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Proyectos->getPrimaryKeys();
    $values = $this->getValue('proyectos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Proyectos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Proyectos', array_values($link));
    }
  }

}
