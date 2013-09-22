<?php

namespace Replanner;

class TaskListController extends BaseController {
	
	public function __invoke() {
		$content = $this->newView('task/index.html');
		return $this->newResponse($content);
	}
}