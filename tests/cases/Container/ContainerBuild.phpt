<?php declare(strict_types = 1);

namespace Tests\Integration\Container;

use Contributte\Tester\Toolkit;
use Nette\Bootstrap\Configurator;
use Nette\DI\Container;
use Tester\Assert;
use Tests\Toolkit\Tests;
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
	$configurator->setTempDirectory(Tests::TEWP_PATH);

	$configurator->addConfig($parameters['rootDir'] . '/config/services.neon');
	$configurator->addStaticParameters($parameters);

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
	$configurator->setTempDirectory(Tests::TEWP_PATH);

	$configurator->addConfig($parameters['rootDir'] . '/config/services.neon');
	$configurator->addStaticParameters($parameters);
	try {
		$configurator->setDebugMode(false);
		$container = $configurator->createContainer();
		Assert::type(Container::class, $container);
	} catch (Throwable $t) {
		Assert::fail(sprintf('Building development container failed. Exception: %s.', $t->getMessage()));
	}
});
