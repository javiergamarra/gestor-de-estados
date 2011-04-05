<?php

/**
 * proyecto actions.
 *
 * @package    gestor
 * @subpackage proyecto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class proyectoActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->proyectos = array();
		if ($this->getUser()->hasPermission('administrador') or $this->getUser()->hasPermission('usuario')
		or $this->getUser()->hasPermission('comite')) {
			$this->proyectosId = array();
			foreach ($this->getUser()->getGuardUser()->getProyectos() as $proyecto) {
				array_push($this->proyectosId,$proyecto->getId());
			}
				
			$this->proyectos = Doctrine_Core::getTable('Proyecto')
			->createQuery('a')
			->andWhereIn('a.id',$this->proyectosId)
			->execute();

		}
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->proyecto);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new ProyectoForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ProyectoForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');

	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('id'))), sprintf('Object proyecto does not exist (%s).', $request->getParameter('id')));
		$this->form = new ProyectoForm($proyecto);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('id'))), sprintf('Object proyecto does not exist (%s).', $request->getParameter('id')));
		$this->form = new ProyectoForm($proyecto);

		$this->processForm($request, $this->form);
		$this->setTemplate('edit');

	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('id'))), sprintf('Object proyecto does not exist (%s).', $request->getParameter('id')));
		$proyecto->delete();

		$this->redirect('proyecto/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$proyecto = $form->save();
			$this->getUser()->setFlash('notice', 'El proyecto se ha modificado con exito');
			$this->redirect('proyecto/edit?id='.$proyecto->getId());

		}
	}
}
