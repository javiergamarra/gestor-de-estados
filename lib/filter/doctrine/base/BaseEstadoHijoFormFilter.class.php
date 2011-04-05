<?php

/**
 * EstadoHijo filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEstadoHijoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mensaje'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mensaje'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('estado_hijo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EstadoHijo';
  }

  public function getFields()
  {
    return array(
      'padre_id' => 'Number',
      'hijo_id'  => 'Number',
      'mensaje'  => 'Text',
    );
  }
}
