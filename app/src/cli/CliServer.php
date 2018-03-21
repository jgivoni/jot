<?php

namespace Jot\cli;

use Jot\config;

class CliServer extends \Ophp\Server {

	protected $userConfig;
	
	protected function newConfig(): config\EnvironmentConfig {
		return new config\EnvironmentConfig;
	}

	public function newRouter(): CliRouter {
		return new CliRouter();
	}

	/**
	 * Request factory
	 * The server knows what kind of request is appropriate here
	 * @return LampRequest
	 */
	public function newRequest() {
		return new \Ophp\requests\CliRequest;
	}

	public function handleRequest(\Ophp\requests\Request $req = null): void {
		parent::handleRequest($req);
	}

	/**
	 * Sends the response to the client
	 * 
	 * @param Response $res
	 */
	public function sendResponse(\Ophp\Response $res) {
		echo (string) $res;
		echo PHP_EOL;
		exit((int) $res->error());
	}

	public function getUserConfig() {
		if (!isset($this->userConfig)) {
			$configFile = $this->getConfig()->files['jot-config'];
			$this->userConfig = parse_ini_file($configFile);
		}
		return $this->userConfig;
	}
}
