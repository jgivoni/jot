<?php

namespace Replanner;

/**
 * This is the script where all requests start
 * Entry point, specified by the webserver (apache)
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

// Bootstrap the entire app by loading and initialising the Application Package
require __DIR__.'/AppPackage.php';
new AppPackage;
// You can create a server for each type of request: webpages, REST, api, json
(new AppServer)->handleRequest();
	
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

if ($name == 'tim') {
	$age = 2;
} elseif ($name == 'viggo') {
	$age = 0;
} elseif ($name == 'bente') {
	$age = 22;
} else {
	$age = 13;
}

switch ($name) {
	case 'tim':
		$age = 2;
		break;
	case 'viggo':
		$age = 0;
		break;
	case 'bente':
		$age = 22;
		break;
	default:
		$age = 13;
}

switch ($name) {
	case 'tim':	$f || $f = function(){return 2;};
	case 'viggo': $f || $f = function(){return 0;};
	case 'bente': $f || $f = function(){return 22;};
	default: $f || $f = function(){return 13;};
		$age = $f();
}

switch ($name) {
	case 'tim':	isset($age) || $age = 2 && ;
	case 'viggo': $f || $f = 0;
	case 'bente': $f || $f = 22;
	default: $f || ($f = 13) && function(){
		
	};
		$age = $f;
}

