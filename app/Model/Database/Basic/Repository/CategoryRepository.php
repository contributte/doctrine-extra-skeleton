<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Repository;

use App\Model\Database\Repository\TRepositoryExtra;
use Doctrine\ORM\EntityRepository;

final class CategoryRepository extends EntityRepository
{

	use TRepositoryExtra;

}
