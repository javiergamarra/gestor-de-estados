<?php

/**
 * Proyecto form.
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProyectoForm extends BaseProyectoForm
{
	public function configure()
	{
		unset(
		$this['created_at'],
		$this['updated_at'],$this['slug']
		);
			$this->widgetSchema->setLabels(array(
  'users_list'    => 'Usuarios asignados',
		));
	}
}
