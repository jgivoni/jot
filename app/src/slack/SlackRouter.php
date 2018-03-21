<?php

namespace Jot\slack;

use Ophp\Router;

class SlackRouter extends \Ophp\Router\UrlRouter {

	public function __construct() {
		$this->addRoute(new Router\RegexRoute('.*', controllers\SlackController::class));
	}

}
