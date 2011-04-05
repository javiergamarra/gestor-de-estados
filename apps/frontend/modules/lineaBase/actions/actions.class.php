<?php

/**
 * lineaBase actions.
 *
 * @package    gestor
 * @subpackage lineaBase
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lineaBaseActions extends sfActions
{

	public function buscarProyecto(sfWebRequest $request) {
		$proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('proyectoId')));
		$this->forward404Unless($proyecto);
		return $proyecto;
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->proyecto = $this->buscarProyecto($request);
		$query = Doctrine_Core::getTable('LineaBase')->buscarLineasBase($this->proyecto->getId(),null);

		$this->linea_bases = $query->execute();
	}

	public function executeShow(sfWebRequest $request)
	{

		$this->proyecto = $this->buscarProyecto($request);
		$this->linea_base = Doctrine_Core::getTable('LineaBase')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->linea_base);
	}

	public function executeNew(sfWebRequest $request)
	{
		$lineaBase = new LineaBase();
		$lineaBase->setProyecto($this->buscarProyecto($request));
		$this->form = new LineaBaseForm($lineaBase);
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new LineaBaseForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($linea_base = Doctrine_Core::getTable('LineaBase')->find(array($request->getParameter('id'))), sprintf('Object linea_base does not exist (%s).', $request->getParameter('id')));
		$this->form = new LineaBaseForm($linea_base);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($linea_base = Doctrine_Core::getTable('LineaBase')->find(array($request->getParameter('id'))), sprintf('Object linea_base does not exist (%s).', $request->getParameter('id')));
		$this->form = new LineaBaseForm($linea_base);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($linea_base = Doctrine_Core::getTable('LineaBase')->find(array($request->getParameter('id'))), sprintf('Object linea_base does not exist (%s).', $request->getParameter('id')));
		$linea_base->delete();

		$this->redirect('lineaBase/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		$form->getObject()->getVersiones()->clear();



		if ($form->isValid())
		{
			$linea_base = $form->save();

			foreach ($linea_base->getProyecto()->getProyecto() as $artefacto) {
				$versionId = $request->getParameter($artefacto->getId());
				if ($versionId) {
					$linea_base->getVersiones()->add(Doctrine_Core::getTable('Version')->find($versionId));
				}
			}
			$linea_base->save();
			$this->getUser()->setFlash('notice', sprintf('Has guardado con exito la linea base '));
			//			$this->redirect('lineaBase/edit?id='.$linea_base->getId());
		}
	}
}
