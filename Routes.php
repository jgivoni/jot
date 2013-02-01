<?php

namespace Replanner;

class Routes {
	
	public function __construct($server) {
		$server
			->addRoute(new \Ophp\RegexRoute('^$', function(){return new IndexController();}))
			->addRoute(new \Ophp\RegexRoute('^/tasks/new(?:/([^/]*))?', function($title){return new NewTaskController($title);}))
			->addRoute(new \Ophp\RegexRoute('\.t(\d+)$', function($taskId) {return new ViewTaskController($taskId);}))
			->addRoute(new \Ophp\RegexRoute('\.t(\d+)/edit$', function($taskId) {return new EditTaskController($taskId);}))
			->addRoute(new \Ophp\RegexRoute('\.t(\d+)/delete', function($taskId) {return new DeleteTaskController($taskId);}))
			->addRoute(new \Ophp\RegexRoute('^/tasks$', function(){return new TaskListController();}))
			->addRoute(new \Ophp\RegexRoute('^/tasks/ajax/reorder/(\d+)$', function($taskId) {return new TaskChangePositionController($taskId);}))
			->addRoute(new \Ophp\RegexRoute('^/tasks/ajax/view/(\d+)$', function($taskId) {return new AjaxViewTaskController($taskId);}))
			;//->addRoute(new RegexRoute('', 'NotFoundController'));
	}
}
