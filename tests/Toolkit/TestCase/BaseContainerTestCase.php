<?php declare(strict_types = 1);

namespace Tests\Toolkit\TestCase;

use Nette\DI\Container;

abstract class BaseContainerTestCase extends BaseTestCase
{

	protected Container $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @param class-string $class
	 */
	protected function getService(string $class): object
	{
		return strpos($class, '\\') !== false ? $this->container->getByType($class) : $this->container->getService($class);
	}

}
