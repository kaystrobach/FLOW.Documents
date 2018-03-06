<?php
namespace KayStrobach\Documents\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Documents". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class FileRepository extends Repository {

	// add customized methods here

    /**
     * @param string $extension
     * @return \TYPO3\Flow\Persistence\QueryResultInterface
     * @throws \TYPO3\Flow\Persistence\Exception\InvalidQueryException
     */
	public function findByExtension($extension) {
		$query = $this->createQuery();
		$query->matching(
			$query->like('originalResource.filename', '%.' . $extension)
		);
		return $query->execute();
	}
}