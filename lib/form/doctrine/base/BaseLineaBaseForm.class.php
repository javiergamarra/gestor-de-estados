<?php

/**
 * LineaBase form base class.
 *
 * @method LineaBase getObject() Returns the current form's model object
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLineaBaseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'nombre'         => new sfWidgetFormInputText(),
      'descripcion'    => new sfWidgetFormTextarea(),
      'proyecto_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'), 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'version'        => new sfWidgetFormInputText(),
      'versiones_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Version')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'         => new sfValidatorString(array('max_length' => 255)),
      'descripcion'    => new sfValidatorString(array('max_length' => 4000)),
      'proyecto_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'))),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'version'        => new sfValidatorInteger(array('required' => false)),
      'versiones_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Version', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('linea_base[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LineaBase';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['versiones_list']))
    {
      $this->setDefault('versiones_list', $this->object->Versiones->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveVersionesList($con);

    parent::doSave($con);
  }

  public function saveVersionesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['versiones_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Versiones->getPrimaryKeys();
    $values = $this->getValue('versiones_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Versiones', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Versiones', array_values($link));
    }
  }

}
