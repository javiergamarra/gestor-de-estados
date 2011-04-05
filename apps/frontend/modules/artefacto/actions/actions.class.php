<?php

/**
 * artefacto actions.
 *
 * @package    gestor
 * @subpackage artefacto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class artefactoActions extends sfActions
{
	public function buscarProyecto(sfWebRequest $request) {
		$proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('proyectoId')));
		$this->forward404Unless($proyecto);
		return $proyecto;
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->proyecto = $this->buscarProyecto($request);
		$query = Doctrine_Core::getTable('Artefacto')->buscarArtefactos($this->proyecto->getId(),null);

		if (!$this->getUser()->hasPermission('comite') and !$this->getUser()->hasPermission('administrador')) {
			$query = Doctrine_Core::getTable('Artefacto')->artefactosValidados($query);
		}
		$this->artefactos = $query->execute();
	}

	public function executeValidar(sfWebRequest $request)
	{
		$this->forward404Unless($artefacto = Doctrine_Core::getTable('Artefacto')->find(array($request->getParameter('id'))), sprintf('Object artefacto does not exist (%s).', $request->getParameter('id')));
		$artefacto -> setValidado(true);
		$artefacto -> save();
		$this->getUser()->setFlash('notice', sprintf('Has validado con exito el artefacto '));
		$this->redirect('artefacto/show?id='.$artefacto->getId().'&proyectoId='.$artefacto->getProyecto()->getId());
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->proyecto = $this->buscarProyecto($request);
		$this->artefacto = Doctrine_Core::getTable('Artefacto')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->artefacto);
	}

	public function executeNew(sfWebRequest $request)
	{
		$artefacto = new Artefacto();
		$artefacto->setProyecto($this->buscarProyecto($request));
		$this->form = new ArtefactoForm($artefacto);
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new ArtefactoForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($artefacto = Doctrine_Core::getTable('Artefacto')->find(array($request->getParameter('id'))), sprintf('Object artefacto does not exist (%s).', $request->getParameter('id')));
		$this->form = new ArtefactoForm($artefacto);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($artefacto = Doctrine_Core::getTable('Artefacto')->find(array($request->getParameter('id'))), sprintf('Object artefacto does not exist (%s).', $request->getParameter('id')));
		$this->form = new ArtefactoForm($artefacto);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($artefacto = Doctrine_Core::getTable('Artefacto')->find(array($request->getParameter('id'))), sprintf('Object artefacto does not exist (%s).', $request->getParameter('id')));
		$artefacto->delete();

		$this->redirect('artefacto/index?proyectoId='.$artefacto->getProyecto()->getId());
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$artefacto = $form->save();

			foreach ($artefacto -> getFicheros() as $fichero) {
				// Class examples
				if ($fichero -> getDeleted()) {
					$fichero -> delete();
				}
			}

			$this->getUser()->setFlash('notice', sprintf('Has guardado con exito el artefacto '));
			$this->redirect('artefacto/edit?id='.$artefacto->getId());
		}
	}

	public function executeDeleteItem(sfWebRequest $request) {
		$fichero = Doctrine::getTable('Ficheros')->find(array($request->getParameter('id')));
		if (!$fichero) {return $this->renderText('Error '.$request->getParameter('id'));}
		$fichero -> setDeleted(true);
		$fichero->save();
		return $this->renderText('ELIMINADO');
	}

	public function executeAddItems(sfWebRequest $request){

		$artefactoId = $request->getParameter('artefactoId');
		if($artefactoId) {
			$index = sfContext::getInstance()->getUser()->getAttribute('N1added'.$artefactoId);
			$configuration = sfProjectConfiguration::getActive();
			$configuration->loadHelpers(array('jQuery','Asset','Tag','Url'));


			$fichero = new Ficheros();

			$fichero->setArtefactoId($artefactoId);

			sfContext::getInstance()->getUser()->setAttribute('inclusion', true);
			$form = new ArtefactoForm();
			$form -> embedForm('item_pos'.++$index, new FicherosForm($fichero));

			$widgetSchema = $form->getWidgetSchema();
			$label = "Fichero $index: ".jq_link_to_remote(image_tag('/sf/sf_admin/images/add'), array(
    			'url'     =>  'artefacto/addItems?artefactoId='.$artefactoId,
    			'update'  =>  'ficheros',
    			'position'=>  'bottom',
			));
			$widgetSchema->setLabel('item_pos'.$index,$label);

			sfContext::getInstance()->getUser()->setAttribute('N1added'.$artefactoId, $index);

			return $this->renderPartial('artefacto/fichero',array
			('index' => $index,'form'=>$form));
		}
	}

	public function executeDescarga($request)
	{
		//Se genera el nombre de fichero
		$nombrefichero=$request->getParameter('fichero');
		$directorio=sfConfig::get('sf_upload_dir').'/'.$nombrefichero;
		$this->logMessage("Ruta al Fichero: ".$directorio);

		$vector = explode(".", $nombrefichero);
		$extension = $vector[count($vector)-1];
		$extension = strtolower($extension);

		if (!file_exists($directorio)) {
			die("Error: No se encuentra el fichero especificado ".$directorio);
		}

		// Establecer el tipo MIME del fichero
		switch($extension) {
			case "gif": header("Content-Type:image/gif"); break;
			case "gz": header("Content-Type:application/x-gzip "); break;
			case "htm": header("Content-Type:text/html "); break;
			case "html": header("Content-Type:text/html "); break;
			case "jpg": header("Content-Type:image/jpeg "); break;
			case "tar": header("Content-Type:application/x-tar "); break;
			case "txt": header("Content-Type:text/plain "); break;
			case "zip": header("Content-Type:application/zip "); break;
			case "pdf": header("Content-Type:application/x-pdf "); break;
			case "doc": header("Content-Type:application/msword "); break;
			default: header("Content-Type:application/octet-stream "); break;
		}

		header('Content-Description: File Transfer');
		//header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$nombrefichero);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($directorio));
		ob_clean();
		flush();
		readfile($directorio);
		exit;

		//$this->redirect('ficheroproyecto/index');
	}
}
