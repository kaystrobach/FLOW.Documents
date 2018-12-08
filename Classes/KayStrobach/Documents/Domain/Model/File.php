<?php
namespace KayStrobach\Documents\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Documents". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class File extends FileSystemNode {

	/**
	 * @var \TYPO3\Flow\ResourceManagement\PersistentResource
	 * @ORM\OneToOne(cascade={"all"})
	 */
	protected $originalResource;

	/**
	 * @var \KayStrobach\Documents\Domain\Model\Folder
	 * @ORM\ManyToOne(inversedBy="files")
	 */
	protected $parentFolder;

	/**
	 * @return \TYPO3\Flow\ResourceManagement\PersistentResource
	 */
	public function getOriginalResource() {
		return $this->originalResource;
	}

	/**
	 * @param \TYPO3\Flow\ResourceManagement\PersistentResource $originalResource
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
