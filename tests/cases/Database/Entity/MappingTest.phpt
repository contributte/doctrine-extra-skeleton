<?php declare(strict_types = 1);

namespace Tests\Integration\Database\Entity;

use Contributte\Tester\Toolkit;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaValidator;
use Nette\DI\Container;
use Tester\Assert;

/** @var Container $container */
$container = require_once __DIR__ . '/../../../bootstrap.container.php';

Toolkit::test(function () use ($container): void {
	/** @var EntityManagerInterface $em */
	$em = $container->getByType(EntityManagerInterface::class);

	// Validation
	$validator = new SchemaValidator($em);
	$validations = $validator->validateMapping();
	foreach ($validations as $fails) {
		foreach ($fails as $fail) {
			Assert::fail($fail);
		}
	}

	Assert::count(0, $validations);
});
