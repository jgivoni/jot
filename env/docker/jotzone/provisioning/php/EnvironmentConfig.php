<?php

namespace Jot\config;

class EnvironmentConfig extends DevelopmentConfig {

	/**
	 * Root url string
	 * This cannot be autodetected yet. Used for links and internal requests and redirects
	 * @var string
	 */
	protected $baseUrl = "http://jotzone.local/";

	/**
	 * List of database connections
	 * - each named connection needs to specify host, db name, user and password
	 * or credentials and region for dynamo db
	 * @var array
	 */
	protected $databaseConnections = array(
		'jot' => array(
			'credentialsFile' => '/.aws/credentials',
			'region' => 'eu-west-1',
		),
		'redis-cache' => [
			'host' => 'redis',
			'port' => 6379,
		]
	);
	protected $paths = array(
		'staticAssets' => 'http://static.jotzone.local/',
	);
	protected $files = [
		'jot-config' => '/home/docker/.jotrc',
	];

}
