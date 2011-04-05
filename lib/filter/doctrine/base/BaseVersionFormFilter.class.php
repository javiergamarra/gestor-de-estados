<?php

/**
 * Version filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'identificador'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'      => new sfWidgetFormFilterInput(),
      'tipo_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tipo'), 'add_empty' => true)),
      'estado_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Estado'), 'add_empty' => true)),
      'artefacto_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Artefacto'), 'add_empty' => true)),
      'validada'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'version'          => new sfWidgetFormFilterInput(),
      'users_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'lineas_base_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LineaBase')),
    ));

    $this->setValidators(array(
      'nombre'           => new sfValidatorPass(array('required' => false)),
      'identificador'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'descripcion'      => new sfValidatorPass(array('required' => false)),
      'tipo_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Tipo'), 'column' => 'id')),
      'estado_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Estado'), 'column' => 'id')),
      'artefacto_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Artefacto'), 'column' => 'id')),
      'validada'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'version'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'users_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'lineas_base_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LineaBase', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addUsersListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.AsignacionTrabajadores AsignacionTrabajadores')
      ->andWhereIn('AsignacionTrabajadores.user_id', $values)
    ;
  }

  public function addLineasBaseListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.LineasVersion LineasVersion')
      ->andWhereIn('LineasVersion.linea_base_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Version';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'nombre'           => 'Text',
      'identificador'    => 'Number',
      'descripcion'      => 'Text',
      'tipo_id'          => 'ForeignKey',
      'estado_id'        => 'ForeignKey',
      'artefacto_id'     => 'ForeignKey',
      'validada'         => 'Boolean',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'version'          => 'Number',
      'users_list'       => 'ManyKey',
      'lineas_base_list' => 'ManyKey',
    );
  }
}
