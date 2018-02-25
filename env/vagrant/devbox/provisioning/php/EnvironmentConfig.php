<?php

namespace Replanner\config;

class EnvironmentConfig extends DevelopmentConfig
{
    /**
     * Root url string
     * This cannot be autodetected yet. Used for links and internal requests and redirects
     * @var string
     */
    protected $baseUrl = "http://replanner.local/";

    /**
     * List of database connections
     * - each named connection needs to specify host, db name, user and password
	 * or credentials and region for dynamo db
     * @var array
     */
    protected $databaseConnections = array(
        'replanner' => array(
            'credentialsFile' => '/home/vagrant/.aws./credentials',
            'region' => 'eu-west-1',
        ),
    );
	
	protected $paths = array(
		'staticAssets' => 'http://static.replanner.local/',
	);


}