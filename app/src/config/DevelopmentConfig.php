<?php

/**
 * Configuration for development runmode
 */

namespace Replanner\config;

class DevelopmentConfig extends \Ophp\Config
{

	protected $runMode = 'development';
	protected $databaseConnections = array(
		'replanner' => array(
			'host' => 'localhost',
			'database' => 'replanner',
			'user' => 'user',
			'password' => '',
		),
	);

}