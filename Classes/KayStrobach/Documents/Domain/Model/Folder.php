<?php
namespace KayStrobach\Documents\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Documents". *
 *                                                                        *
 *                                                                        */

use KayStrobach\Documents\Domain\Repository\WorkspaceRepository;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Folder extends FileSystemNode{

	/**
	 * @Flow\Inject()
	 * @var WorkspaceRepository
	 */
	protected $workspaceRepository;

	/**
	 * @var \KayStrobach\Documents\Domain\Model\Folder
	 * @ORM\ManyToOne(inversedBy="folders")
	 */
	protected $parentFolder;

	/**
	 * Folder Children
	 *
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Documents\Domain\Model\Folder>
	 * @ORM\OneToMany(cascade={"all"}, orphanRemoval=TRUE, mappedBy="parentFolder"))
	 * @ORM\OrderBy({"name" = "ASC"})
	 */
	protected $folders;

	/**
	 * File Children
	 *
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Documents\Domain\Model\File>
	 * @ORM\OneToMany(cascade={"all"}, orphanRemoval=TRUE, mappedBy="parentFolder"))
	 * @ORM\OrderBy({"name" = "ASC"})
	 */
	protected $files;

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

	/**
	 * @return mixed
	 */
	public function getFolders() {
		return $this->folders;
	}

	/**
	 * @param mixed $folders
	 */
	public function setFolders($folders) {
		$this->folders = $folders;
	}

	/**
	 * @param Folder $folder
	 */
	public function addFolder(Folder $folder) {
		$this->folders->add($folder);
	}

	/**
	 * @param Folder $folder
	 */
	public function removeFolder(Folder $folder) {
		$this->folders->remove($folder);
	}

	/**
	 * @return mixed
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * @param mixed $files
	 */
	public function setFiles($files) {
		$this->files = $files;
	}

	/**
	 * @param File $file
	 */
	public function addFile(File $file) {
		$this->files->add($file);
	}

	/**
	 * @param File $file
	 */
	public function removeFile(File $file) {
		$this->files->remove($file);
	}

	/**
	 * @return Folder
	 */
	public function getTopMostParentFolder() {
		/** @var Folder $parentFolder */
		$folder = $this;
		while($folder->getParentFolder() !== NULL) {
			$folder = $folder->getParentFolder();
		}
		return $folder;
	}

	/**
	 * @return Workspace
	 */
	public function getWorkspace() {
		return $this->workspaceRepository->findByRootFolder($this->getTopMostParentFolder());
	}
}
