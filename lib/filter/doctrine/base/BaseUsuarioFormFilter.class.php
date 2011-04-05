<?php

/**
 * Usuario filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUsuarioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nombre'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'apellido1'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'apellido2'       => new sfWidgetFormFilterInput(),
      'rol_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rol'), 'add_empty' => true)),
      'asignaciones_id' => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'proyectos_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Proyecto')),
    ));

    $this->setValidators(array(
      'email'           => new sfValidatorPass(array('required' => false)),
      'nombre'          => new sfValidatorPass(array('required' => false)),
      'apellido1'       => new sfValidatorPass(array('required' => false)),
      'apellido2'       => new sfValidatorPass(array('required' => false)),
      'rol_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Rol'), 'column' => 'id')),
      'asignaciones_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'proyectos_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Proyecto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addProyectosListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.AsignacionProyectos AsignacionProyectos')
      ->andWhereIn('AsignacionProyectos.proyecto_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Usuario';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'email'           => 'Text',
      'nombre'          => 'Text',
      'apellido1'       => 'Text',
      'apellido2'       => 'Text',
      'rol_id'          => 'ForeignKey',
      'asignaciones_id' => 'Number',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'proyectos_list'  => 'ManyKey',
    );
  }
}
