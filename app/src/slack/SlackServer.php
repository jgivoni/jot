<?php

namespace Replanner\slack;

use Replanner\config;

class SlackServer extends \Ophp\WebServer {

	protected $userConfig;

	protected function newConfig(): config\EnvironmentConfig {
		return new config\EnvironmentConfig;
	}

	public function newRouter(): SlackRouter {
		return new SlackRouter();
	}

	/**
	 * Request factory
	 * The server knows what kind of request is appropriate here
	 * @return LampRequest
	 */
	public function newRequest() {
		return new \Ophp\requests\HttpRequest;
	}

}
