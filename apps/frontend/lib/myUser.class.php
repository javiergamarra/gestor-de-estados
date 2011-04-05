<?php

class myUser extends sfGuardSecurityUser
{
	public function cargarPermisos() {
		if (!$this->hasAttribute('permisos')) {
			$this->inicializarPermisos();
		}
		$permisos = $this->getAttribute("permisos",array());
		if ($this->hasPermission('administrador')) {
			return $permisos;
		} else if ($this->hasPermission('usuario')) {
			return array($permisos[Estado::CREADA],$permisos[Estado::INFO]);
		} else if ($this->hasPermission('testeador')) {
			return array($permisos[Estado::RESUELTA]);
		} else if ($this->hasPermission('desarrollador')) {
			return array($permisos[Estado::ASIGNADA],$permisos[Estado::TEST]);
		} else if ($this->hasPermission('comite')) {
			return array($permisos[Estado::SOLICITADA],$permisos[Estado::ABIERTA]
			,$permisos[Estado::POSPUESTA]
			,$permisos[Estado::RECHAZADA]
			,$permisos[Estado::DUPLICADA]
			,$permisos[Estado::CERRADA]
			,$permisos[Estado::VERIFICADA]
			);
		}
	}

	public function inicializarPermisos() {
		$permisos = array(Estado::CREADA => Estado::crearEstado(Estado::CREADA)
		,Estado::SOLICITADA =>Estado::crearEstado(Estado::SOLICITADA)
		,Estado::ABIERTA =>Estado::crearEstado(Estado::ABIERTA)
		,Estado::POSPUESTA =>Estado::crearEstado(Estado::POSPUESTA)
		,Estado::RECHAZADA =>Estado::crearEstado(Estado::RECHAZADA)
		,Estado::INFO =>Estado::crearEstado(Estado::INFO)
		,Estado::DUPLICADA =>Estado::crearEstado(Estado::DUPLICADA)
		,Estado::CERRADA =>Estado::crearEstado(Estado::CERRADA)
		,Estado::ASIGNADA =>Estado::crearEstado(Estado::ASIGNADA)
		,Estado::RESUELTA =>Estado::crearEstado(Estado::RESUELTA)
		,Estado::TEST =>Estado::crearEstado(Estado::TEST)
		,Estado::VERIFICADA =>Estado::crearEstado(Estado::VERIFICADA),
		);
		$this->setAttribute('permisos', $permisos);
		return $permisos;
	}
	
	public function getGrupo() {
		$grupo = $this->getGroups();
		return $grupo[0];
	}
	

}
