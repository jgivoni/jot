<?php

class IndexController extends BaseController {
	
	public function __invoke() {
		$view = $this->newView('index.html');
		return $this->newResponse()->body($view);
	}
	
}