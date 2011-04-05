<?php

/**
 * Artefacto
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    gestor
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Artefacto extends BaseArtefacto
{

	public function __toString() {
		return $this->getNombre();
	}

	public function getVersionesValidadas() {
		$versionesvalidades = array ();
		foreach ($this->getVersiones() as $version) {
			if ($version->getValidada()) {
				array_push($versionesvalidades,($version));
			}
		}
		return $versionesvalidades;
	}

}