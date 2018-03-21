<?php

namespace Jot\api;

/**s
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
(new ApiServer)->handleRequest();
	
/**
 * Editing a book
 * req.path: mybook.b1/edit
 * GET: Show form
 * PUT/POST: Validate input, accept, store and redirect or show form again
 * .b1 => load book, show 404 if not found
 * /edit => check user, authorisation
 * 
 * BookController: Loads book
 * AuthorisationController: Checks if user has authorisation, can user edit a/this book?
 * AuthenticationController: Checks user credentials, is user logged in?
 * BookNotFoundController: 404 for non-existent book
 * EditBookController: Book form
 * SaveBookController: Store submitted data
 * ViewBookController: View book data
 */
