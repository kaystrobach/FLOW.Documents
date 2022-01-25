<?php

namespace KayStrobach\Documents\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Documents". *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\ResourceManagement\PersistentResource;

/**
 * @Flow\Entity
 */
class File extends FileSystemNode
{

    /**
     * @var PersistentResource
     * @ORM\OneToOne(cascade={"all"})
     */
    protected $originalResource;

    /**
     * @var Folder
     * @ORM\ManyToOne(inversedBy="files")
     */
    protected $parentFolder;

    /**
     * @return PersistentResource
     */
    public function getOriginalResource()
    {
        return $this->originalResource;
    }

    /**
     * @param PersistentResource $originalResource
     */
    public function setOriginalResource($originalResource)
    {
        $this->originalResource = $originalResource;
    }

    /**
     * @return Folder
     */
    public function getParentFolder()
    {
        return $this->parentFolder;
    }

    /**
     * @param Folder $parentFolder
     */
    public function setParentFolder($parentFolder)
    {
        $this->parentFolder = $parentFolder;
    }


}
