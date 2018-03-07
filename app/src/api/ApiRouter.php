<?php

namespace Replanner\api;

use Ophp\Router;
use Replanner\api\controllers;

class ApiRouter extends \Ophp\Router\UrlRouter {
	public function __construct() {
		$this->addRoute(new Router\RegexRoute('^$', controllers\ApiController::class));
		$this->addRoute(new Router\RegexRoute('^insert/(.*)$', controllers\InsertController::class));
		$this->addRoute(new Router\RegexRoute('^update/(.*)/(.*)$', controllers\UpdateController::class));
		$this->addRoute(new Router\RegexRoute('^delete/(.*)$', controllers\DeleteController::class));
		$this->addRoute(new Router\RegexRoute('^get/(.*)$', controllers\GetController::class));
		$this->addRoute(new Router\RegexRoute('^getbatch/(.*)$', controllers\GetBatchController::class));
		$this->addRoute(new Router\RegexRoute('^link/(.*)/(.*)$', controllers\LinkController::class));
		$this->addRoute(new Router\RegexRoute('^unlink/(.*)/(.*)$', controllers\UnlinkController::class));
		$this->addRoute(new Router\RegexRoute('^query/(.*)$', controllers\QueryController::class));
	}
}
