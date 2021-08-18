<?php declare(strict_types = 1);

namespace Tests\Integration\Database;

use App\Model\Database\Entity\Entity;
use App\Model\Database\TRepositories;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Nette\DI\Container;
use Ninjify\Nunjuck\Toolkit;
use ReflectionClass;
use Tester\Assert;

/** @var Container $container */
$container = require_once __DIR__ . '/../../bootstrap.container.php';

Toolkit::test(function () use ($container): void {
	/** @var EntityManagerInterface $em */
	$em = $container->getByType(EntityManagerInterface::class);

	/** @var ClassMetadata[] $metadata */
	$metadata = $em->getMetadataFactory()->getAllMetadata();

	foreach ($metadata as $item) {
		$rf = new ReflectionClass($item->getName());

		if (!is_subclass_of($rf->getName(), Entity::class)) {
			continue;
		}

		$methodName = 'get' . $rf->getShortName() . 'Repository';

		Assert::true(
			method_exists($em, $methodName),
			sprintf('Method %s() not exist in %s or %s', $methodName, TRepositories::class, EntityManager::class)
		);

		Assert::same($em->getRepository($item->getName()), $em->$methodName());
	}
});
