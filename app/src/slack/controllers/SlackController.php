<?php

namespace Replanner\slack\controllers;

/**
 * 
 * OAuth Access Token: xoxp-327958999443-328906075702-328079565056-020efbc9b8acd6d36570ab3574030f6d
 * 
 * @method \Replanner\cli\CliServer getServer
 * @method \Ophp\requests\CliRequest getRequest
 */
class SlackController extends \Ophp\Controller {

	public function __construct() {
		
	}

	protected function newResponse() {
		$res = new \Ophp\HttpResponse;
		return $res;
	}
	
	protected function getCliResult() {
		$slackRequest = $this->getServer()->getRequest();

		$cliRequest = new \Ophp\requests\CliRequest;
		$cliRequest->command = $slackRequest->getParam('command');
		$cliRequest->params = explode(' ', $slackRequest->getParam('text'));
		$cliRequest->setServerVars(['XDG_SESSION_ID' => 'slackuserid']);
		$cliServer = new \Replanner\cli\CliServer;
		$cliResponse = $cliServer->getResponse($cliRequest);

		return $cliResponse->body;
	}

	public function __invoke() {
		$output = $this->getCliResult();
		return $this->newResponse()->body($output);
	}

}
