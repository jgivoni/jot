<?php

$server
	->addRoute(new RegexRoute2('^$', function(){return new IndexController();}))
	->addRoute(new RegexRoute('^/tasks/new(?:/([^/]*))?', 'NewTaskController'))
	->addRoute(new RegexRoute2('\.t(\d+)$', function($taskId) {return new ViewTaskController($taskId);}))
	->addRoute(new RegexRoute2('\.t(\d+)/edit$', function($taskId) {return new EditTaskController($taskId);}))
	->addRoute(new RegexRoute2('\.t(\d+)/delete', function($taskId) {return new DeleteTaskController($taskId);}))
	->addRoute(new RegexRoute('^/tasks$', 'TaskListController'))
	->addRoute(new RegexRoute2('^/tasks/ajax/reorder/(\d+)$', function($taskId) {return new TaskChangePositionController($taskId);}))
	->addRoute(new RegexRoute2('^/tasks/ajax/view/(\d+)$', function($taskId) {return new AjaxViewTaskController($taskId);}))
	;//->addRoute(new RegexRoute('', 'NotFoundController'));
