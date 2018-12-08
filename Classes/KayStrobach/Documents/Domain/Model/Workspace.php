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
class Workspace extends FileSystemNode {

	/**
	 * @var \KayStrobach\Documents\Domain\Model\Folder
	 * @ORM\ManyToOne(cascade={"all"})
	 */
	protected $folder;

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @return Folder
	 */
	public function getFolder() {
		return $this->folder;
	}

	/**
	 * @param Folder $folder
	 */
	public function setFolder($folder) {
		$this->folder = $folder;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

}