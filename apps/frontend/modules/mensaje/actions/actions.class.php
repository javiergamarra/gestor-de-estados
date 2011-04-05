<?php

/**
 * mensaje actions.
 *
 * @package    gestor
 * @subpackage mensaje
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mensajeActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->mensajes = Doctrine_Core::getTable('Mensaje')
		->createQuery('a')
		->addWhere('a.user_id = ?', $this->getUser()->getGuardUser()->getId())
		->orderBy('a.created_at desc')
		->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->mensaje = Doctrine_Core::getTable('Mensaje')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->mensaje);
		$this->mensaje->setLeido(true);
		$this->mensaje->save();
		sfContext::getInstance()->getUser()->setAttribute('mensajes',Doctrine_Core::getTable('Mensaje')-> mensajesActivos()-> count());
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new MensajeForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new MensajeForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($mensaje = Doctrine_Core::getTable('Mensaje')->find(array($request->getParameter('id'))), sprintf('Object mensaje does not exist (%s).', $request->getParameter('id')));
		$this->form = new MensajeForm($mensaje);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($mensaje = Doctrine_Core::getTable('Mensaje')->find(array($request->getParameter('id'))), sprintf('Object mensaje does not exist (%s).', $request->getParameter('id')));
		$this->form = new MensajeForm($mensaje);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($mensaje = Doctrine_Core::getTable('Mensaje')->find(array($request->getParameter('id'))), sprintf('Object mensaje does not exist (%s).', $request->getParameter('id')));
		$mensaje->delete();

		$this->redirect('mensaje/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$mensaje = $form->save();

			$this->redirect('mensaje/edit?id='.$mensaje->getId());
		}
	}
}
