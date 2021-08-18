<?php declare(strict_types = 1);

namespace Tests\Integration\Container;

use Nette\Configurator;
use Nette\DI\Container;
use Ninjify\Nunjuck\Toolkit;
use Tester\Assert;
use Throwable;

require_once __DIR__ . '/../../bootstrap.php';

$rootDir = realpath(__DIR__ . '/../../..');
$parameters = [
	'rootDir' => $rootDir,
	'appDir' => $rootDir . '/app',
	'wwwDir' => $rootDir . '/www',
	'database' => [
		'host' => 'fake',
		'user' => 'fake',
		'password' => 'fake',
		'dbname' => 'fake',
	],
];

// Production container build
Toolkit::test(function () use ($parameters): void {
	$configurator = new Configurator();
	$configurator->setTempDirectory(TEMP_DIR);

	$configurator->addConfig($parameters['rootDir'] . '/config/services.neon');
	$configurator->addParameters($parameters);

	try {
		$configurator->setDebugMode(false);
		$container = $configurator->createContainer();
		Assert::type(Container::class, $container);
	} catch (Throwable $t) {
		Assert::fail(sprintf('Building production container failed. Exception: %s.', $t->getMessage()));
	}
});

// Development container build
Toolkit::test(function () use ($parameters): void {
	$configurator = new Configurator();
	$configurator->setTempDirectory(TEMP_DIR);

	$configurator->addConfig($parameters['rootDir'] . '/config/services.neon');
	$configurator->addParameters($parameters);
	try {
		$configurator->setDebugMode(false);
		$container = $configurator->createContainer();
		Assert::type(Container::class, $container);
	} catch (Throwable $t) {
		Assert::fail(sprintf('Building development container failed. Exception: %s.', $t->getMessage()));
	}
});
