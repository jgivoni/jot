<?php

namespace Replanner\cli\controllers;

/**
 * @method \Replanner\cli\CliServer getServer
 * @method \Ophp\requests\CliRequest getRequest
 */
abstract class CliController extends \Ophp\Controller {

	public function __construct() {
		parent::__construct();
		session_id($_SERVER['XDG_SESSION_ID']);
		session_start();
	}

	public function getItemId($key) {
		$userConfig = $this->getServer()->getUserConfig();
		return isset($userConfig[$key]) ? $userConfig[$key] : null;
	}

	protected function getApiResult($query) {
		$apiRequest = new \Ophp\requests\HttpRequest;
		$apiRequest->url = $query;
		$apiRequest->addHeader('X-Jot-Identity', $this->getServer()->getUserConfig()['me']);
		$apiServer = new \Replanner\api\ApiServer;
		$apiResponse = $apiServer->getResponse($apiRequest);

		$result = $apiResponse->body['result'];
		return $result;
	}

}
