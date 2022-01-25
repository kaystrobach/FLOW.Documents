<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 13.12.14
 * Time: 09:22
 */

namespace KayStrobach\Documents\Controller;

use KayStrobach\Documents\Domain\Model\File;
use KayStrobach\Documents\Domain\Model\Folder;
use Neos\Flow\Annotations as Flow;

class FolderController extends \Neos\Flow\Mvc\Controller\ActionController {
	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Documents\Domain\Repository\FolderRepository
	 */
	protected $folderRepository;

	/**
	 * @param Folder $folder
	 */
	public function indexAction(Folder $folder) {
		$this->view->assign(
				'folder',
				$folder
		);
	}

	/**
	 * @param Folder $parentFolder
	 */
	public function newAction(Folder $parentFolder = NULL) {
		$this->view->assign('parentFolder', $parentFolder);
	}

	/**
	 * @param Folder $folder
	 * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
	 */
	public function createAction(Folder $folder) {
		$this->folderRepository->add($folder);
		$this->redirect('index', NULL, NULL, array('folder' => $folder->getParentFolder()));
	}

	/**
	 * @param Folder $folder
	 */
	public function editAction(Folder $folder) {
		$this->view->assign('folder', $folder);
	}

	/**
	 * @param Folder $folder
	 */
	public function updateAction(Folder $folder) {
		$this->folderRepository->update($folder);
		$this->redirect(
			'index',
			NULL,
			NULL,
			array(
				'folder' => $folder->getParentFolder()
			)
		);
	}

	public function removeAction(Folder $folder) {
		$this->folderRepository->remove($folder);
		if($folder->getParentFolder() !== NULL) {
			$this->redirect(
				'index',
				NULL,
				NULL,
				array(
					'folder' => $folder->getParentFolder()
				)
			);
		}
		$this->redirect('index', 'workspace');
	}
}
