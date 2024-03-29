<?php declare(strict_types = 1);

namespace App;

use Contributte\Bootstrap\ExtraConfigurator;
use Nette\Bootstrap\Configurator;

class Bootstrap
{

	public static function boot(): Configurator
	{
		$configurator = new ExtraConfigurator();

		// According to NETTE_DEBUG env
		$configurator->setEnvDebugMode();

		$configurator->enableTracy(__DIR__ . '/../var/log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../var/tmp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator
			->addConfig(__DIR__ . '/../config/services.neon');

		$configurator
			->addConfig(__DIR__ . '/../config/local.neon');

		return $configurator;
	}

}
