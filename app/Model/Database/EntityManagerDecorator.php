<?php declare(strict_types = 1);

namespace App\Model\Database;

use Doctrine\ORM\Decorator\EntityManagerDecorator as DoctrineEntityManagerDecorator;

/**
 * Custom EntityManagerDecorator
 */
final class EntityManagerDecorator extends DoctrineEntityManagerDecorator
{

	use TRepositories;

}
