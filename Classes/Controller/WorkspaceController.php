<?php

namespace KayStrobach\Documents\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Documents". *
 *                                                                        *
 *                                                                        */

use KayStrobach\Documents\Domain\Model\File;
use KayStrobach\Documents\Domain\Model\Folder;
use KayStrobach\Documents\Domain\Model\Workspace;
use KayStrobach\Documents\Domain\Repository\WorkspaceRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Persistence\Exception\IllegalObjectTypeException;

class WorkspaceController extends ActionController
{

    /**
     * @Flow\Inject
     * @var WorkspaceRepository
     */
    protected $workspaceRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign(
            'workspaces',
            $this->workspaceRepository->findAll()
        );
    }

    /**
     * form for creating a new workspace
     */
    public function newAction()
    {

    }


    /**
     * creates a new workspace in the repository
     *
     * @param Workspace $workspace
     * @throws IllegalObjectTypeException
     */
    public function createAction(Workspace $workspace)
    {
        $folder = new Folder();
        $folder->setName('Workspace Root ' . $workspace->getName());
        $workspace->setFolder($folder);
        $this->workspaceRepository->add($workspace);
        $this->redirect('index');
    }


    /**
     * form for updating a workspace
     *
     * @param Workspace $workspace
     */
    public function editAction(Workspace $workspace)
    {
        $this->view->assign('workspace', $workspace);
    }

    /**
     * save an updated workspace
     *
     * @param Workspace $workspace
     * @throws IllegalObjectTypeException
     */
    public function updateAction(Workspace $workspace)
    {
        $this->workspaceRepository->update($workspace);
        $this->redirect('index');
    }

    /**
     * @param Workspace $workspace
     * @throws IllegalObjectTypeException
     */
    public function removeAction(Workspace $workspace)
    {
        $this->workspaceRepository->remove($workspace);
        $this->redirect('index');
    }
}
