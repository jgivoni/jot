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

	public function handleRequest(\Ophp\requests\Request $req = null) {
		parent::handleRequest($req);
	}

	public function getAppRootPath() {
		return __DIR__;
	}

	public function newDynamoDbDatabaseAdapter(string $key): \Ophp\dba\DynamoDbDatabaseAdapter {
		return new \Ophp\dba\DynamoDbDatabaseAdapter($this->getConfig()->databaseConnections[$key]);
	}

	public function newRedisCacheClient() {
		$config = $this->getConfig()->databaseConnections['redis-cache'];
		$redis = new \Redis();
		$redis->connect($config['host'], $config['port']);
		$redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
		return $redis;
	}

}
