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
use KayStrobach\Documents\Domain\Repository\FolderRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Persistence\Exception\IllegalObjectTypeException;

class FolderController extends ActionController
{
    /**
     * @Flow\Inject
     * @var FolderRepository
     */
    protected $folderRepository;

    /**
     * @param Folder $folder
     */
    public function indexAction(Folder $folder)
    {
        $this->view->assign(
            'folder',
            $folder
        );
    }

    /**
     * @param Folder $parentFolder
     */
    public function newAction(Folder $parentFolder = null)
    {
        $this->view->assign('parentFolder', $parentFolder);
    }

    /**
     * @param Folder $folder
     * @throws IllegalObjectTypeException
     */
    public function createAction(Folder $folder)
    {
        $this->folderRepository->add($folder);
        $this->redirect('index', null, null, array('folder' => $folder->getParentFolder()));
    }

    /**
     * @param Folder $folder
     */
    public function editAction(Folder $folder)
    {
        $this->view->assign('folder', $folder);
    }

    /**
     * @param Folder $folder
     */
    public function updateAction(Folder $folder)
    {
        $this->folderRepository->update($folder);
        $this->redirect(
            'index',
            null,
            null,
            array(
                'folder' => $folder->getParentFolder()
            )
        );
    }

    public function removeAction(Folder $folder)
    {
        $this->folderRepository->remove($folder);
        if ($folder->getParentFolder() !== null) {
            $this->redirect(
                'index',
                null,
                null,
                array(
                    'folder' => $folder->getParentFolder()
                )
            );
        }
        $this->redirect('index', 'workspace');
    }
}
