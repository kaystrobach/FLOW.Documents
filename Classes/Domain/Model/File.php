<?php
namespace KayStrobach\Documents\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Documents". *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class File extends FileSystemNode {

	/**
	 * @var \Neos\Flow\ResourceManagement\PersistentResource
	 * @ORM\OneToOne(cascade={"all"})
	 */
	protected $originalResource;

	/**
	 * @var \KayStrobach\Documents\Domain\Model\Folder
	 * @ORM\ManyToOne(inversedBy="files")
	 */
	protected $parentFolder;

	/**
	 * @return \Neos\Flow\ResourceManagement\PersistentResource
	 */
	public function getOriginalResource() {
		return $this->originalResource;
	}

	/**
	 * @param \Neos\Flow\ResourceManagement\PersistentResource $originalResource
	 */
	public function setOriginalResource($originalResource) {
		$this->originalResource = $originalResource;
	}

	/**
	 * @return Folder
	 */
	public function getParentFolder() {
		return $this->parentFolder;
	}

	/**
	 * @param Folder $parentFolder
	 */
	public function setParentFolder($parentFolder) {
		$this->parentFolder = $parentFolder;
	}


}
