<?php

namespace Replanner\api;

use Ophp\Router;
use Replanner\api\controllers;

class ApiRouter extends \Ophp\Router\UrlRouter {
	public function __construct() {
		$this->addRoute(new Router\RegexRoute('^$', controllers\ApiController::class));
		$this->addRoute(new Router\RegexRoute('^insert$', controllers\InsertController::class));
	}
}
