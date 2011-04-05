<?php

/**
 * sfGuardUserTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class sfGuardUserTable extends PluginsfGuardUserTable
{
	/**
	 * Returns an instance of this class.
	 *
	 * @return object sfGuardUserTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('sfGuardUser');
	}

	public static function getUsuariosProyecto() {
		$query = Doctrine_Query::create()
		->from('sfGuardUser u')
		->leftJoin('u.Proyectos p')
		->addWhere('p.id = ?', sfContext::getInstance()->getUser()->getAttribute('Proyecto'));
		return $query->execute();
	}

}