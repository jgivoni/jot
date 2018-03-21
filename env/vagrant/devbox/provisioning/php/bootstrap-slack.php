<?php

namespace Jot\slack;

/**
 * This is the script where all requests start
 * Entry point, specified by the web server (apache)
 * 
 * Responsibilities:
 * Bootstrap all packages, load the routes and handle the request
 */

// Dummy php setup
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!ini_get('date.timezone')) {
	date_default_timezone_set('Europe/Madrid');
}

// Composer autoloader
require_once '/jot/app/vendor/autoload.php';

// Local environment configuration
require_once 'EnvironmentConfig.php';

// You can create a server for each type of request: webpages, REST, api, json, cli
(new SlackServer)->handleRequest();
	