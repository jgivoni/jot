<?php

namespace Replanner\api;

use Replanner\config;

class ApiServer extends \Ophp\WebServer {

	protected function newConfig() {
		return new config\EnvironmentConfig;
	}
	
	public function newRouter() {
		return new ApiRouter();
	}
	
	public function handleRequest(\Ophp\requests\HttpRequest $req = null) {
		parent::handleRequest($req);
	}
	
	public function getAppRootPath()
	{
		return __DIR__;
	}

	public function newDynamoDbDatabaseAdapter(string $key) : \Ophp\dba\DynamoDbDatabaseAdapter{
		return new \Ophp\dba\DynamoDbDatabaseAdapter($this->getConfig()->databaseConnections[$key]);
	}

}
