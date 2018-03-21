<?php

/**
 * Configuration for development runmode
 */

namespace Jot\config;

class DevelopmentConfig extends \Ophp\Config
{

	protected $runMode = 'development';
	protected $databaseConnections = array(
		'jot' => array(
			'host' => 'localhost',
			'database' => 'jot',
			'user' => 'user',
			'password' => '',
		),
	);

}