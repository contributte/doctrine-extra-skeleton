<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Entity;
use Doctrine\ORM\EntityRepository;
use RuntimeException;

/**
 * @mixin EntityRepository
 */
trait TRepositoryExtra
{

	/**
	 * @param string $value
	 * @param string $key
	 * @return mixed[]
	 */
	public function findPairs($value, $key = 'id'): array
	{
		$select = [];
		$categories = $this->createQueryBuilder('e')
			->select('e.' . $key, 'e.' . $value)
			->getQuery()
			->getArrayResult();
		foreach ($categories as $category) {
			$select[$category[$key]] = $category[$value];
		}

		return $select;
	}

	public function fetch(int $id, ?int $lockMode = null, ?int $lockVersion = null): Entity
	{
		/** @var Entity|null $entity */
		$entity = $this->find($id, $lockMode, $lockVersion);

		if ($entity === null) {
			throw new RuntimeException('Entity not found');
		}

		return $entity;
	}

	/**
	 * @param mixed[] $criteria
	 * @param mixed[]|null $orderBy
	 */
	public function fetchBy(array $criteria, ?array $orderBy = null): Entity
	{
		/** @var Entity|null $entity */
		$entity = $this->findOneBy($criteria, $orderBy);

		if ($entity === null) {
			throw new RuntimeException('Entity not found');
		}

		return $entity;
	}

}
