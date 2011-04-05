<?php

/**
 * LineaBase form.
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LineaBaseForm extends BaseLineaBaseForm
{
	public function configure()
	{
		unset(
		$this['created_at'],
		$this['updated_at'],$this['version'],$this['versiones_list']
		);
		$this->widgetSchema['proyecto_id'] = new sfWidgetFormInputHidden();

		$this->validatorSchema->setOption('allow_extra_fields', true);
	}

	public function bind(array $taintedValues = null, array $taintedFiles = null)
	{
		return parent::bind($taintedValues,$taintedFiles);
	}
}
