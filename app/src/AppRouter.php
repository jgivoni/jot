<?php

namespace Replanner;

use Ophp\Router;
use Replanner\controllers;

class AppRouter extends \Ophp\Router\UrlRouter {
	public function __construct() {
		$this->addRoute(new Router\RegexRoute('^$', controllers\IndexController::class))
			->addRoute(new Router\RegexRoute('^tasks/new(?:/([^/]*))?$', function($title=''){return new controllers\tasks\NewTaskController($title);}))
			->addRoute(new Router\RegexRoute('^tasks/cards$', function(){return new controllers\CardsController();}))
			->addRoute(new Router\RegexRoute('\.t(\d+)$', controllers\tasks\ViewTaskController::class))
			->addRoute(new Router\RegexRoute('\.t(\d+)/edit$', function($taskId) {return new controllers\EditTaskController($taskId);}))
			->addRoute(new Router\RegexRoute('\.t(\d+)/delete', function($taskId) {return new controllers\DeleteTaskController($taskId);}))
			->addRoute(new Router\RegexRoute('^tasks$', controllers\tasks\ListTaskController::class))
			->addRoute(new Router\RegexRoute('^tasks/ajax/reorder/(\d+)$', function($taskId) {return new controllers\TaskChangePositionController($taskId);}))
			->addRoute(new Router\RegexRoute('^tasks/ajax/view/(\d+)$', function($taskId) {return new controllers\AjaxViewTaskController($taskId);}))
			->addRoute(new Router\RegexRoute('', function() {return new controllers\NotFoundController;}));
	}
}
