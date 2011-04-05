<?php

/**
 * VersionVersion filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVersionVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'identificador' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'   => new sfWidgetFormFilterInput(),
      'tipo_id'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'estado_id'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'artefacto_id'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'validada'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'nombre'        => new sfValidatorPass(array('required' => false)),
      'identificador' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'descripcion'   => new sfValidatorPass(array('required' => false)),
      'tipo_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'estado_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'artefacto_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'validada'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('version_version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VersionVersion';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'nombre'        => 'Text',
      'identificador' => 'Number',
      'descripcion'   => 'Text',
      'tipo_id'       => 'Number',
      'estado_id'     => 'Number',
      'artefacto_id'  => 'Number',
      'validada'      => 'Boolean',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
      'version'       => 'Number',
    );
  }
}
