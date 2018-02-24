<?php

namespace Replanner;

class AppServer extends \Ophp\Server {

	protected $appRootPath = __DIR__;
	
	protected function newConfig() {
		return new EnvironmentConfig;
	}
	
	public function newRouter() {
		return new AppRouter();
	}
	
	public function handleRequest(\Ophp\HttpRequest $req = null) {
		if ($this->isDevelopment()) {
			new \FirePhp\FirePhpPackage;
		}

		parent::handleRequest($req);
	}
}
