<?php

/**
 * Artefacto form.
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArtefactoForm extends BaseArtefactoForm
{
	public function configure()
	{
		$this->validatorSchema->setOption('allow_extra_fields', true);

		unset(
		$this['created_at'],
		$this['updated_at'],$this['version'],$this['hijos_list'],$this['validado']
		);
		$this->widgetSchema['proyecto_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema->setLabel('padres_list','Artefactos de los que forma parte');

		sfContext::getInstance()->getUser()->setAttribute('Proyecto', $this->getObject()->getProyecto()->getId());
		//		$this->widgetSchema['users_list'] = new sfWidgetFormDoctrineChoice(array(
		//  			'table_method'  => 'getUsuariosProyecto',
		//			'model'  => 'sfGuardUser',
		//			'multiple' => true,
		//  			'expanded' => true,
		//		));
		//		$this->widgetSchema['users_list']->setLabel('Usuarios asignados (disponibles del proyecto)');

		$configuration = sfProjectConfiguration::getActive();
		$configuration->loadHelpers(array('jQuery','Asset','Tag','Url'));
		$index = 0;
		foreach ($this->getObject()->getFicheros() as $fichero){
			$this->embedForm('item_pos'.++$index, new FicherosArtForm($fichero));
			$label = "Fichero $index: ".jq_link_to_remote(image_tag('/sf/sf_admin/images/delete'), array(
      'url'     =>  'artefacto/deleteItem?id='.$fichero->getId(),
  	  'update'  =>  'ficheros',
      'confirm' => 'Estas seguro?',
			));
			$this->widgetSchema->setLabel('item_pos'.$index,$label);
		}

		if (!sfContext::getInstance()->getUser()->getAttribute('inclusion')) {
			$fichero = new FicherosArt();
			$fichero->setArtefacto($this->getObject());
			$this->embedForm('item_pos'.++$index, new FicherosArtForm($fichero));

			if ($this->getObject()->getId()) {
				$label = "Fichero $index: ".jq_link_to_remote(image_tag('/sf/sf_admin/images/add'), array(
				'url'     =>  'artefacto/addItems?artefactoId='.$this->getObject()->getId(),
				'update'  =>  'ficheros',
				'position'=>  'after',
				));
			} else {
				$label = "Fichero ";
			}
			$this->widgetSchema->setLabel('item_pos'.$index,$label);

		}

		sfContext::getInstance()->getUser()->setAttribute('N1added'.$this->getObject()->getId(), $index);

		sfContext::getInstance()->getUser()->setAttribute('Proyecto', $this->getObject()->getProyecto()->getId());

//		$this->widgetSchema['users_list'] = new sfWidgetFormDoctrineChoice(array(
//  			'table_method'  => 'getUsuariosProyecto',
//			'model'  => 'sfGuardUser',
//			'multiple' => true,
//  			'expanded' => true,
//		));

	}

	public function bind(array $taintedValues = null, array $taintedFiles = null)
	{

		for($i=1;$i<=10;$i++)
		{

			if(!isset($taintedValues["item_pos$i"]))
			{
				//	 		Eliminar forms inútiles
				unset($this->embeddedForms["item_pos$i"],$this->validatorSchema["item_pos$i"]);
				unset($taintedValues['item_pos'.$i]);
			} else {
				if (!empty($taintedValues["item_pos$i"]['nombre'])) {
					if (!isset($this->embeddedForms['item_pos'.$i])) {

						//	 			Nuevos Ficheros
						$fichero = new Ficheros();
						$fichero->setNombre($taintedValues["item_pos$i"]['nombre']);
						$fichero->setFile($taintedValues["item_pos$i"]['file']);
						$fichero->setArtefacto($this->getObject());
						$this->embedForm('item_pos'.$i, new FicherosForm($fichero));
					} else {
						if ($this->embeddedForms['item_pos'.$i]->getObject() -> getDeleted()) {

							//	 					$this->embeddedForms['item_pos'.$i]-> getObject() -> delete();
							$this->getObject()->getFicheros();
							unset($this->embeddedForms["item_pos$i"],$this->validatorSchema["item_pos$i"]);
							unset($taintedValues['item_pos'.$i]);
						} else {
							$this->embeddedForms['item_pos'.$i]->getObject()->setArtefacto($this->getObject());
						}
					}
				} else {
					unset($this->embeddedForms["item_pos$i"],$this->validatorSchema["item_pos$i"]);
					unset($taintedValues['item_pos'.$i]);
				}
			}

		}

		return parent::bind($taintedValues,$taintedFiles);
	}
}
