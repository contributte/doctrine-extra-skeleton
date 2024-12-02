<?php declare(strict_types = 1);

namespace App\Router;

use Nette\Application\Routers\RouteList;

final class RouterFactory
{

	public static function create(): RouteList
	{
		$router = new RouteList();

		$router->addRoute('<presenter>[[/<locale=en>][/<action>]]', [
			'presenter' => 'Basic',
			'action' => 'default',
			'locale' => 'en',
		]);

		return $router;
	}

}
