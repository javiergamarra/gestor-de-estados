<?php

/**
 * MensajeTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MensajeTable extends Doctrine_Table
{
	/**
	 * Returns an instance of this class.
	 *
	 * @return object MensajeTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Mensaje');
	}

	public function mensajesActivos(Doctrine_Query $q = null)
	{
		if (is_null($q))
		{
			$q = Doctrine_Query::create()
			->from('Mensaje m')
			->addWhere('m.user_id = ?', sfContext::getInstance()->getUser()->getGuardUser()->getId());
		}

		$alias = $q->getRootAlias();

		$q->andWhere($alias . '.leido = 0');

		return $q;
	}
	
}