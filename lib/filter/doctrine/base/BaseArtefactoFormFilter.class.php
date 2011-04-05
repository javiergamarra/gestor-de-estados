<?php

/**
 * Artefacto filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseArtefactoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipo_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tipo'), 'add_empty' => true)),
      'proyecto_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'), 'add_empty' => true)),
      'validado'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'version'     => new sfWidgetFormFilterInput(),
      'padres_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto')),
      'hijos_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto')),
    ));

    $this->setValidators(array(
      'nombre'      => new sfValidatorPass(array('required' => false)),
      'descripcion' => new sfValidatorPass(array('required' => false)),
      'tipo_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Tipo'), 'column' => 'id')),
      'proyecto_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Proyecto'), 'column' => 'id')),
      'validado'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'version'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'padres_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto', 'required' => false)),
      'hijos_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Artefacto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('artefacto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addPadresListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Relaciones Relaciones')
      ->andWhereIn('Relaciones.hijo_id', $values)
    ;
  }

  public function addHijosListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Relaciones Relaciones')
      ->andWhereIn('Relaciones.padre_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Artefacto';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'nombre'      => 'Text',
      'descripcion' => 'Text',
      'tipo_id'     => 'ForeignKey',
      'proyecto_id' => 'ForeignKey',
      'validado'    => 'Boolean',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'version'     => 'Number',
      'padres_list' => 'ManyKey',
      'hijos_list'  => 'ManyKey',
    );
  }
}
