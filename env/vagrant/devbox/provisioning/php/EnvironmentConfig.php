<?php

namespace Replanner;

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
     * @var array
     */
    protected $databaseConnections = array(
        'replanner' => array(
            'host' => 'localhost',
            'database' => 'replanner',
            'user' => 'webapp',
            'password' => '',
        ),
    );

}