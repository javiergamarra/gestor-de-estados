<?php

/**
 * Ficheros filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFicherosFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'      => new sfWidgetFormFilterInput(),
      'file'        => new sfWidgetFormFilterInput(),
      'versionid'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Version'), 'add_empty' => true)),
      'descripcion' => new sfWidgetFormFilterInput(),
      'deleted'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'      => new sfValidatorPass(array('required' => false)),
      'file'        => new sfValidatorPass(array('required' => false)),
      'versionid'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Version'), 'column' => 'id')),
      'descripcion' => new sfValidatorPass(array('required' => false)),
      'deleted'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('ficheros_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ficheros';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'nombre'      => 'Text',
      'file'        => 'Text',
      'versionid'   => 'ForeignKey',
      'descripcion' => 'Text',
      'deleted'     => 'Boolean',
    );
  }
}
