<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 13.12.14
 * Time: 09:22
 */

namespace KayStrobach\Documents\Controller;

use InvalidArgumentException;
use KayStrobach\Documents\Domain\Model\File;
use KayStrobach\Documents\Domain\Model\Folder;
use KayStrobach\Documents\Domain\Repository\FileRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Error\Messages\Message;
use Neos\Flow\Http\Component\SetHeaderComponent;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Mvc\Exception\StopActionException;
use Neos\Flow\Persistence\Exception\IllegalObjectTypeException;
use Neos\Flow\ResourceManagement\Exception as ResourceNotFoundException;
use Neos\Flow\ResourceManagement\PersistentResource;
use Neos\Flow\ResourceManagement\ResourceManager;

class FileController extends ActionController
{

    /**
     * @Flow\Inject
     * @var FileRepository
     */
    protected $fileRepository;

    /**
     * @Flow\Inject
     * @var ResourceManager
     */
    protected $resourceManager;

    /**
     * @param Folder $parentFolder
     */
    public function newAction(Folder $parentFolder)
    {
        $this->view->assign('parentFolder', $parentFolder);
    }

    /**
     * Upload a file
     *
     * @param File $file
     */
    public function createAction(File $file)
    {
        $file->setName($file->getOriginalResource()->getFilename());
        $this->fileRepository->add($file);
        $this->redirect(
            'index',
            'folder',
            null,
            array(
                'folder' => $file->getParentFolder()
            )
        );
    }

    /**
     * edit a file
     *
     * @param File $file
     */
    public function editAction(File $file)
    {
        $this->view->assign('file', $file);
    }

    /**
     * update a file
     *
     * @param File $file
     */
    public function updateAction(File $file)
    {
        $this->fileRepository->update($file);
        $this->redirect(
            'index',
            'folder',
            null,
            array(
                'folder' => $file->getParentFolder()
            )
        );
    }

    /**
     * @param File $file
     * @return string
     * @throws InvalidArgumentException
     * @throws StopActionException
     */
    public function downloadAction(File $file)
    {
        $response = $this->controllerContext->getResponse();
        $response->setContentType($file->getOriginalResource()->getMediaType());

        $response->setComponentParameter(
            SetHeaderComponent::class,
            'Content-Length',
            $file->getOriginalResource()->getFileSize()
        );
        $response->setComponentParameter(
            SetHeaderComponent::class,
            'Content-Disposition',
            'attachment;filename="' . $file->getName() . '"'
        );
        $response->setComponentParameter(
            SetHeaderComponent::class,
            'Cache-Control',
            'max-age=0'
        );

        try {
            $tempCopyPath = $file->getOriginalResource()->createTemporaryLocalCopy();
            $buffer = @file_get_contents($tempCopyPath);
            unlink($tempCopyPath);
            return $buffer;
        } catch (ResourceNotFoundException $exception) {
            $this->systemLogger->logException($exception);
            $this->addFlashMessage(
                $exception->getMessage(),
                '',
                Message::SEVERITY_ERROR
            );
        }
        $this->forwardToReferringRequest();
        $this->redirect(
            'index',
            'Workspace'
        );
    }

    /**
     * removes a file
     *
     * @param File $file
     * @throws IllegalObjectTypeException
     */
    public function removeAction(File $file)
    {
        $this->fileRepository->remove($file);
        $this->redirect('index', 'folder', null, array('folder' => $file->getParentFolder()));
    }

    /**
     * action for html5 multifile upload
     *
     * @param Folder $folder
     */
    public function multiUploadAction(Folder $folder)
    {
        if (isset($_FILES) && !empty($_FILES)) {
            $count = 0;
            foreach ($_FILES as $file) {
                if ($file['name'][$count] != "") {
                    $resource = array(
                        'tmp_name' => $file['tmp_name'][$count],
                        'name' => $file['name'][$count]
                    );
                    /** @var PersistentResource $newResource */
                    $newResource = $this->resourceManager->importUploadedResource($resource);
                    $newFile = new File();
                    $newFile->setParentFolder($folder);
                    $newFile->setOriginalResource($newResource);
                    $newFile->setName($newResource->getFilename());
                    $this->fileRepository->add($newFile);
                    $count++;
                }
            }
        }
        $this->redirect(
            'index',
            'Folder',
            null,
            array(
                'folder' => $folder
            )
        );
    }

}
