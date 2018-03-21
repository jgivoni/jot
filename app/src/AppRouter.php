<?php

namespace Jot;

use Ophp\Router;
use Jot\controllers;

class AppRouter extends \Ophp\Router\UrlRouter {
	public function __construct() {
		$this->addRoute(new Router\RegexRoute('^$', controllers\IndexController::class))
			->addRoute(new Router\RegexRoute('^item/(.*)$', controllers\ItemController::class))
			->addRoute(new Router\RegexRoute('^add/?$', controllers\AddController::class))
			->addRoute(new Router\RegexRoute('', function() {return new controllers\NotFoundController;}));
	}
}
