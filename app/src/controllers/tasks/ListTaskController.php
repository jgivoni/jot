<?php

namespace Jot\controllers\tasks;

class ListTaskController extends \Jot\controllers\TaskController {
	
	public function __invoke() {
		$content = $this->newView('task/index.html');
		return $this->newResponse($content);
	}
}