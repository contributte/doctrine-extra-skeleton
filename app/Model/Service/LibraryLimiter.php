<?php declare(strict_types = 1);

namespace App\Model\Service;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;
use LengthException;

/**
 * Naive implementation of library limiter that checks the size of book library
 * and throws exception if the limit is exceeded
 */
final class LibraryLimiter implements EventSubscriber
{

	/**
	 * Maximum number of books to be stored in DB
	 */
	public const LIBRARY_MAX_SIZE = 10;

	/**
	 * Returns an array of events this subscriber wants to listen to.
	 *
	 * @return array<string>
	 */
	public function getSubscribedEvents(): array
	{
		return [
			Events::postLoad,
		];
	}

	public function postLoad(PostLoadEventArgs $args): void
	{
		$schemaManager = $args->getObjectManager()->getConnection()->createSchemaManager();

		if ($schemaManager->tablesExist(['book']) === true) {
			$all = $args->getObjectManager()->getConnection()->fetchAllAssociative('SELECT id FROM book');

			if (count($all) > self::LIBRARY_MAX_SIZE) {
				throw new LengthException('Oops. Too many books were placed in such a small library and it collapsed.');
			}
		}
	}

}
