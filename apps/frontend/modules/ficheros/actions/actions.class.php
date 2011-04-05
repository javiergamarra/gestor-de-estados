<?php

/**
 * ficheros actions.
 *
 * @package    fundacion
 * @subpackage ficheros
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ficherosActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->ficheros_list = Doctrine::getTable('Ficheros')
		->createQuery('a')
		->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->ficheros = Doctrine::getTable('Ficheros')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->ficheros);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new FicherosForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));

		$this->form = new FicherosForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($ficheros = Doctrine::getTable('Ficheros')->find(array($request->getParameter('id'))), sprintf('Object ficheros does not exist (%s).', array($request->getParameter('id'))));
		$this->form = new FicherosForm($ficheros);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($ficheros = Doctrine::getTable('Ficheros')->find(array($request->getParameter('id'))), sprintf('Object ficheros does not exist (%s).', array($request->getParameter('id'))));
		$this->form = new FicherosForm($ficheros);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($ficheros = Doctrine::getTable('Ficheros')->find(array($request->getParameter('id'))), sprintf('Object ficheros does not exist (%s).', array($request->getParameter('id'))));
		$ficheros->delete();

		$this->redirect('ficheros/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		//$form->bind($request->getParameter($form->getName()));
		$form->bind($request->getParameter($form->getName('ficheros')), $request->getFiles('ficheros'));
		 
		if ($form->isValid())
		{
			//Este metodo es para formularios doctrine
			//$form->saveFile ($field, $filename = null, $file = null);

			//Recoge archivo
			$file = $form->getValue('file');
			//Ruta de subida
			$directorio=sfConfig::get('sf_upload_dir').'/ficheros';

			//Si el directorio no existe le creo
			if (!is_dir($directorio))
			{
				mkdir ($directorio,0777);
			}

			$this-> existe_fichero = false;

			if (is_file($directorio.'/'.$file->getOriginalName()))
			{
				$this->logMessage("EXISTE UN FICHERO CON EL MISMO NOMBRE: " . $file->getOriginalName() ,"debug" );
				$this-> existe_fichero = true;
				$this->getUser()->setFlash('error', 'YA EXISTE UN FICHERO CON EL MISMO NOMBRE');
			}
			else{//si no existe el fichero lo guardamos
				//Guardo (subo) el fichero
				$file->save($directorio.'/'.$file->getOriginalName());
				//Actualizo el objeto del formulario
				$form->updateObject();
				//Añado los campos "propios"
				$form->getObject()->setFile($file->getOriginalName());
				//guardo el objeto
				$form->getObject()->save();
			}
			$this->redirect('ficheros/new');
		}
	}
}
