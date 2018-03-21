<?php

namespace Jot\cli;

use Ophp\Router;
use Jot\cli\controllers;

class CliRouter extends \Ophp\Router\CommandRouter {

	public function __construct() {
		$this->addRoute(new Router\SimpleRoute('jot', controllers\AddController::class));
		$this->addRoute(new Router\SimpleRoute('jotadd', controllers\AddController::class));
		$this->addRoute(new Router\SimpleRoute('jotget', controllers\GetController::class));
		$this->addRoute(new Router\SimpleRoute('jottag', controllers\TagController::class));
		$this->addRoute(new Router\SimpleRoute('jotlink', controllers\LinkController::class));
		$this->addRoute(new Router\SimpleRoute('jotupdate', controllers\UpdateController::class));
		$this->addRoute(new Router\SimpleRoute('jotdelete', controllers\DeleteController::class));
	}

}
