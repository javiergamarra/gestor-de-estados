<?php

/**
 * Estado
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    gestor
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Estado extends BaseEstado
{
	const CREADA = "Creada";
	const SOLICITADA = "Solicitada";
	const ABIERTA = "Abierta";
	const POSPUESTA = "Pospuesta";
	const RECHAZADA = "Rechazada";
	const INFO = "Necesita_mas_informacion";
	const DUPLICADA = "Duplicada";
	const CERRADA = "Cerrada";
	const ASIGNADA = "Asignada";
	const RESUELTA = "Resuelta";
	const TEST = "Test_fallido";
	const VERIFICADA = "Verificada";

	public function __toString() {
		return $this->getDescripcion();
	}

	public static function crearEstado($nombre)
	{
		return Doctrine_Core::getTable('Estado')
		->createQuery('a')
		->where('a.nombre like ?', $nombre)
		->execute()
		->getFirst();
	}

	public function getMensaje() {
		return "Guardar y pasar a ".$this->descripcion;
	}

	public function getAsignable() {
		return Estado::ABIERTA == $this->getNombre();
	}


	public function getHijos(Doctrine_Query $q = null)
	{
		if (is_null($q))
		{
			$q = Doctrine_Query::create()
			->from('EstadoHijo e')
			->addWhere('e.padre_id = ?', $this->getId());
		}

		$alias = $q->getRootAlias();

		return $q->execute();
	}

}