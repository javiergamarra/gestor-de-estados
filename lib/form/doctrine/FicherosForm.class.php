<?php

/**
 * Ficheros form.
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FicherosForm extends BaseFicherosForm
{
	public function configure()
	{
		unset(
		$this['versionid']
		);
			
		$this->widgetSchema->setLabel('nombre', 'Nombre');
			
		$this->validatorSchema->setOption('allow_extra_fields', true);
		$this->widgetSchema['deleted'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['file'] = new sfWidgetFormInputFile();
		$this->validatorSchema['file'] = new sfValidatorFile();

		$this->setValidator("file", new sfValidatorFile(array(
        "required"  => false, 
		"path" => sfConfig::get('sf_upload_dir').$this->getObject()->getFile(),
        "max_size"  => 10487565
		)));
	}
}
