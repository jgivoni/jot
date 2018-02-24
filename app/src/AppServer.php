<?php

namespace Replanner;

class AppServer extends \Ophp\WebServer {

	protected function newConfig() {
		return new config\EnvironmentConfig;
	}
	
	public function newRouter() {
		return new AppRouter();
	}
	
	public function handleRequest(\Ophp\requests\HttpRequest $req = null) {
		parent::handleRequest($req);
	}
	
	public function getAppRootPath()
	{
		return __DIR__;
	}

	public function newMysqlDatabaseAdapter($key) {
		$config = $this->getConfig();
		$db = $config->databaseConnections[$key];
		$dba = new MysqlDatabaseAdapter($db['host'], $db['database'], $db['user'], $db['password']);
		if ($this->isDevelopment()) {
			$dba = new DbaDebugDecorator($dba);
		}
		return $dba;
	}
	
	public function newDynamoDbDatabaseAdapter($key) {
		$config = $this->getConfig();
		$db = $config->databaseConnections[$key];
		$dba = new DynamoDbDatabaseAdapter($db['region'], $db['table']);
		return $dba;
	}

}
