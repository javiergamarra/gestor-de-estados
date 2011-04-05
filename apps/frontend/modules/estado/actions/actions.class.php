<?php

/**
 * estado actions.
 *
 * @package    gestor
 * @subpackage estado
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class estadoActions extends sfActions
{

	public function executePit(sfWebRequest $request)
	{
		if ($request->isXmlHttpRequest())
		{
			return $this->renderText('No results.');
		}
	}
	public function executeIndex(sfWebRequest $request)
	{
		$this->estados = Doctrine_Core::getTable('Estado')
		->createQuery('a')
		->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->estado = Doctrine_Core::getTable('Estado')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->estado);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new EstadoForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new EstadoForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($estado = Doctrine_Core::getTable('Estado')->find(array($request->getParameter('id'))), sprintf('Object estado does not exist (%s).', $request->getParameter('id')));
		$this->form = new EstadoForm($estado);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($estado = Doctrine_Core::getTable('Estado')->find(array($request->getParameter('id'))), sprintf('Object estado does not exist (%s).', $request->getParameter('id')));
		$this->form = new EstadoForm($estado);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($estado = Doctrine_Core::getTable('Estado')->find(array($request->getParameter('id'))), sprintf('Object estado does not exist (%s).', $request->getParameter('id')));
		$estado->delete();

		$this->redirect('estado/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$estado = $form->save();
			$this->getUser()->setFlash('notice', 'El estado se ha guardado correctamente');
			$this->redirect('estado/edit?id='.$estado->getId());
		}
	}
}
