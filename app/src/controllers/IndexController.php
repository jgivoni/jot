<?php

namespace Replanner\controllers;

class IndexController extends Controller {

	/**
	 * Returns a response with a list of important tasks
	 * @return \Ophp\HttpResponse
	 */
	public function __invoke() {
		$view = $this->newView('index.html');
		return $this->newResponse()->body($view);
	}

}
