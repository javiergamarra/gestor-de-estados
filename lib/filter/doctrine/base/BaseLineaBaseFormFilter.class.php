<?php

/**
 * LineaBase filter form base class.
 *
 * @package    gestor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLineaBaseFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'proyecto_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'version'        => new sfWidgetFormFilterInput(),
      'versiones_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Version')),
    ));

    $this->setValidators(array(
      'nombre'         => new sfValidatorPass(array('required' => false)),
      'descripcion'    => new sfValidatorPass(array('required' => false)),
      'proyecto_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Proyecto'), 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'version'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'versiones_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Version', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('linea_base_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addVersionesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('LineasVersion.version_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'LineaBase';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'nombre'         => 'Text',
      'descripcion'    => 'Text',
      'proyecto_id'    => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'version'        => 'Number',
      'versiones_list' => 'ManyKey',
    );
  }
}
