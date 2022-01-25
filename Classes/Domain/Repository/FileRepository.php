<?php
namespace KayStrobach\Documents\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Documents". *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class FileRepository extends Repository {

	// add customized methods here

    /**
     * @param string $extension
     * @return \Neos\Flow\Persistence\QueryResultInterface
     * @throws \Neos\Flow\Persistence\Exception\InvalidQueryException
     */
	public function findByExtension($extension) {
		$query = $this->createQuery();
		$query->matching(
			$query->like('originalResource.filename', '%.' . $extension)
		);
		return $query->execute();
	}
}