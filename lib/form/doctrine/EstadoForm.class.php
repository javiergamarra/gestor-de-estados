<?php

/**
 * Estado form.
 *
 * @package    gestor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EstadoForm extends BaseEstadoForm
{
	public function configure()
	{
		unset(
		$this['created_at'],
		$this['updated_at'],$this['asignaciones_id'],$this['proyectos_list']
		);
		
		$this->widgetSchema['estados_hijos_list']->setLabel('Estados hijos posibles');
	}
}
