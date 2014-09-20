<?php

namespace Replanner;

class ListTaskController extends TaskController {
	
	public function __invoke() {
		$content = $this->newView('task/index.html');
		return $this->newResponse($content);
	}
}