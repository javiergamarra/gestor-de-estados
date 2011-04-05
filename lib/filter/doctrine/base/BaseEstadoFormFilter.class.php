<?php

/**
 * Estado filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEstadoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'        => new sfWidgetFormFilterInput(),
      'fase'               => new sfWidgetFormFilterInput(),
      'edicion'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'estados_hijos_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Estado')),
    ));

    $this->setValidators(array(
      'nombre'             => new sfValidatorPass(array('required' => false)),
      'descripcion'        => new sfValidatorPass(array('required' => false)),
      'fase'               => new sfValidatorPass(array('required' => false)),
      'edicion'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'estados_hijos_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Estado', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('estado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addEstadosHijosListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.EstadoHijo EstadoHijo')
      ->andWhereIn('EstadoHijo.hijo_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Estado';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'nombre'             => 'Text',
      'descripcion'        => 'Text',
      'fase'               => 'Text',
      'edicion'            => 'Boolean',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'estados_hijos_list' => 'ManyKey',
    );
  }
}
