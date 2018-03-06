#!/usr/bin/env php
<?
namespace Replanner\cli;

// Dummy php setup
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!ini_get('date.timezone')) {
	date_default_timezone_set('Europe/Madrid');
}

// Composer autoloader
require_once '/replanner/app/vendor/autoload.php';

// Local environment configuration
require_once 'EnvironmentConfig.php';

// You can create a server for each type of request: webpages, REST, api, json, cli
(new CliServer)->handleRequest();
