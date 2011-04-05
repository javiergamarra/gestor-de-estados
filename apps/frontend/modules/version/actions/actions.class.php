<?php

/**
 * version actions.
 *
 * @package    gestor
 * @subpackage version
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class versionActions extends sfActions
{

	public function findArtefacto(sfWebRequest $request) {
		return Doctrine_Core::getTable('Artefacto')->find(array($request->getParameter('artefactoId')));
	}

	public function buscarArtefacto(sfWebRequest $request) {
		$artefacto = $this->findArtefacto($request);
		$this->forward404Unless($artefacto);
		return $artefacto;
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->artefacto = $this->findArtefacto($request);
		$this->pendientes = false;
		if ($request->getParameter('pendientes')) {
			$this->pendientes = true;
			$permisos = $this->getUser()->cargarPermisos();
			$permisosIds = array();
			foreach ($permisos as $permiso):
			array_push($permisosIds,$permiso->getId());
			endforeach;


			$this->versions = Doctrine_Core::getTable('Version')
			->createQuery('a')
			->leftJoin('a.Estado e')
			->whereIn('e.id',$permisosIds)
			->orderBy('a.updated_at desc')
			->execute();
		} else {
			if (!$this->artefacto) {
				$this->versions = Doctrine_Core::getTable('Version')
				->createQuery('a')
				->orderBy('a.updated_at desc')
				->execute();
			} else {
				$this->versions = Doctrine_Core::getTable('Version')
				->createQuery('a')
				->where('a.artefacto_id = ?', $this->artefacto->getId())
				->orderBy('a.updated_at desc')
				->execute();
			}
		}


	}

	public function executeShow(sfWebRequest $request)
	{
		$this->artefacto = $this->buscarArtefacto($request);
		$this->version = Doctrine_Core::getTable('Version')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->version);
	}

	public function executeNew(sfWebRequest $request)
	{
		$version = new Version();
		sfContext::getInstance()->getUser()->setAttribute('inclusion', false);
		$this->estado = Estado::crearEstado(Estado::CREADA);
		$version->setValidada(false);
		$version->setEstado($this->estado);
		$version->setArtefacto($this->buscarArtefacto($request));
		$this->forward404Unless($version->tramitable());
		$this->form = new VersionForm($version);

	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new VersionForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($version = Doctrine_Core::getTable('Version')->find(array($request->getParameter('id'))), sprintf('Object version does not exist (%s).', $request->getParameter('id')));
		$version->delete();

		$this->redirect('version/index?artefactoId='.$version->getArtefacto()->getId());
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$version = $form->save();

			$permisos = $this->getUser()->inicializarPermisos();
			foreach ($permisos as $permiso):
			if ($request->hasParameter($permiso->getNombre())) {

				if ($permiso == Estado::CERRADA and $version->getEstado()->getNombre() == Estado::VERIFICADA) {
					$version->setValidada(true);
					$svn = new subversion();

					foreach ($version->getFicheros() as $fichero) {
						$this->emptyDir(sfConfig::get('sf_root_dir').'/web/uploads2');
						copy(sfConfig::get('sf_root_dir').'/web/uploads/'.$fichero -> getFile(),sfConfig::get('sf_root_dir').'/web/uploads2/'.$fichero -> getFile());
						$this->logMessage(sfConfig::get('sf_root_dir').'/web/uploads/'.$fichero -> getFile(),'err');
						$this->logMessage(sfConfig::get('sf_root_dir').'/web/uploads2/'.$fichero -> getFile(),'err');
						$svn->addFile('proyect', sfConfig::get('sf_root_dir').'/web/uploads2');
						$svn->updateFile('proyect', sfConfig::get('sf_root_dir').'/web/uploads2');
						copy(sfConfig::get('sf_root_dir').'/web/uploads/'.$fichero -> getFile(),sfConfig::get('sf_root_dir').'/web/uploads3/'.$fichero -> getFile());
					}
				}

				$version->setEstado($permiso);
				$version->save();
				$this->getUser()->setFlash('notice', sprintf('Has tramitado con exito a peticion con estado '.$permiso));

				$usuarios = $version->getUsers();


				if (!empty($usuarios)) {
					foreach ($usuarios as $user) {
						$mensaje = new Mensaje();
						$mensaje -> setNombre('Tramitacion');
						$mensaje -> setLeido(false);
						$mensaje -> setSfGuardUser($user);
						$mensaje -> setDescripcion('Se ha tramitado una solicitud de cambio del artefacto '.$version->getArtefacto().' a estado '.$permiso);
						$mensaje -> save();
						sfContext::getInstance()->getUser()->setAttribute('mensajes',Doctrine_Core::getTable('Mensaje')-> mensajesActivos()-> count());
					}
				}


			}
			endforeach;
			//			$this->getUser()->setFlash('notice', sprintf('Has tramitado con exito el cambio'));
			foreach ($version -> getFicheros() as $fichero) {
				//				require_once 'class.subversion.php';
				// Class examples
				if ($fichero -> getDeleted()) {
					$fichero -> delete();
				}
			}

			$this->redirect('version/show?id='.$version->getId().'&artefactoId='.$version->getArtefactoId());
		}
	}

	function emptyDir($path) {

		// INITIALIZE THE DEBUG STRING
		$debugStr = '';
		$debugStr .= "Deleting Contents Of: $path<br /><br />";
		// PARSE THE FOLDER
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					// IF IT"S A FILE THEN DELETE IT
					if(is_file($path."/".$file)) {
						if(unlink($path."/".$file)) {
							$debugStr .= "Deleted File: ".$file."<br />";
						}
					} else {
						// IT IS A DIRECTORY
						// CRAWL THROUGH THE DIRECTORY AND DELETE IT'S CONTENTS
						if($handle2 = opendir($path."/".$file)) {
							while (false !== ($file2 = readdir($handle2))) {
								if ($file2 != "." && $file2 != "..") {
									if(unlink($path."/".$file."/".$file2)) {
										$debugStr .= "Deleted File: $file/$file2<br />";
									}
								}

							}

						}

						if(rmdir($path."/".$file)) {
							$debugStr .= "Directory: ".$file."<br />";
						}

					}

				}

			}

		}
		return $debugStr;
	}

	public function executeDeleteItem(sfWebRequest $request) {
		$fichero = Doctrine::getTable('Ficheros')->find(array($request->getParameter('id')));
		if (!$fichero) {return $this->renderText('Error '.$request->getParameter('id'));}
		$fichero -> setDeleted(true);
		$fichero->save();
		return $this->renderText('ELIMINADO');
	}

	public function executeAddItems(sfWebRequest $request){

		$versionId = $request->getParameter('versionId');
		if($versionId) {
			$index = sfContext::getInstance()->getUser()->getAttribute('N1added'.$versionId);
			$configuration = sfProjectConfiguration::getActive();
			$configuration->loadHelpers(array('jQuery','Asset','Tag','Url'));


			$fichero = new Ficheros();

			$fichero->setversionId($versionId);

			sfContext::getInstance()->getUser()->setAttribute('inclusion', true);
			$form = new VersionForm();
			$form -> embedForm('item_pos'.++$index, new FicherosForm($fichero));

			$widgetSchema = $form->getWidgetSchema();
			$label = "Fichero $index: ".jq_link_to_remote(image_tag('/sf/sf_admin/images/add'), array(
    			'url'     =>  'version/addItems?versionId='.$versionId,
    			'update'  =>  'ficheros',
    			'position'=>  'bottom',
			));
			$widgetSchema->setLabel('item_pos'.$index,$label);

			sfContext::getInstance()->getUser()->setAttribute('N1added'.$versionId, $index);

			return $this->renderPartial('version/fichero',array
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


	/*
	 public function executeEnviar(sfWebRequest $request)
	 {
		<?php if (!$form->getObject()->isNew() and $form->getObject()->enviar()): ?>
		&nbsp;<?php echo url_for('version/enviar?id='.$form->getObject()->getId().'&artefactoId='.$form->getObject()->getArtefacto()->getId()) ?>
		<?php endif; ?>
		$this->artefacto = $this->buscarArtefacto($request);
		$this->versions = Doctrine_Core::getTable('Version')
		->createQuery('a')
		->where('a.artefacto_id = ?', $this->artefacto->getId())
		->where('a.estado_id = ?', Estado::crearEstado(Estado::SOLICITADA))
		->execute();
		}
		*/
	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($version = Doctrine_Core::getTable('Version')->find(array($request->getParameter('id'))), sprintf('Object version does not exist (%s).', $request->getParameter('id')));
		$this->form = new VersionForm($version);

		$this->processForm($request, $this->form);

		$this->setTemplate('tramitar');
	}

	public function executeTramitar(sfWebRequest $request)
	{
		sfContext::getInstance()->getUser()->setAttribute('inclusion', false);
		$this->forward404Unless($version = Doctrine_Core::getTable('Version')->find(array($request->getParameter('id'))), sprintf('Object version does not exist (%s).', $request->getParameter('id')));
		$this->forward404Unless(sfContext::getInstance()->getUser()->hasPermission($version->getEstado()->getNombre()));
		$this->form = new VersionForm($version);
	}

	public function executePublish(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($version = Doctrine_Core::getTable('Version')->find(array($request->getParameter('id'))), sprintf('Object version does not exist (%s).', $request->getParameter('id')));
		$this->form = new VersionForm($version);

		$this->processForm($request, $this->form);

		$this->setTemplate('tramitar');

	}

}
