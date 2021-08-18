<?php declare(strict_types = 1);

namespace App\Model\Database\Advanced\Repository;

use App\Model\Database\Repository\TRepositoryExtra;
use Doctrine\ORM\EntityRepository;

final class ArticleRepository extends EntityRepository
{

	use TRepositoryExtra;

}
