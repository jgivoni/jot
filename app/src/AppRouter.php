<?php

namespace Replanner;

use Ophp\Router;
use Replanner\controllers;

class AppRouter extends \Ophp\Router\UrlRouter {
	public function __construct() {
		$this->addRoute(new Router\RegexRoute('^$', controllers\IndexController::class))
			->addRoute(new Router\RegexRoute('^item/(.*)$', controllers\tasks\ItemController::class))
			->addRoute(new Router\RegexRoute('', function() {return new controllers\NotFoundController;}));
	}
}
