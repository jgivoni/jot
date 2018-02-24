<?php

namespace Replanner;

class AppServer extends \Ophp\Server {

	protected $appRootPath = __DIR__;
	
	protected function newConfig() {
		return new config\EnvironmentConfig;
	}
	
	public function newRouter() {
		return new AppRouter();
	}
	
	public function handleRequest(\Ophp\requests\HttpRequest $req = null) {
		parent::handleRequest($req);
	}
}
