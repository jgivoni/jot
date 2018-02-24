<?php

namespace Replanner\controllers\tasks;

class ListTaskController extends \Replanner\controllers\TaskController {
	
	public function __invoke() {
		$content = $this->newView('task/index.html');
		return $this->newResponse($content);
	}
}