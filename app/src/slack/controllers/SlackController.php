<?php

namespace Jot\slack\controllers;

/**
 * 
 * OAuth Access Token: xoxp-327958999443-328906075702-328079565056-020efbc9b8acd6d36570ab3574030f6d
 * 
 * @method \Jot\cli\CliServer getServer
 * @method \Ophp\requests\CliRequest getRequest
 */
class SlackController extends \Ophp\Controller {

	public function __construct() {
		
	}

	protected function newResponse() {
		$res = new \Ophp\HttpResponse;
		$res->header('Content-Type', 'application/json; charset=utf-8');
		return $res;
	}

	protected function getCliResult() {
		$slackRequest = $this->getServer()->getRequest();

		$command = $slackRequest->isPost() ? $slackRequest->getPostParam('command') : $slackRequest->getParam('command');
		$args = $slackRequest->isPost() ? $slackRequest->getPostParam('text') : $slackRequest->getParam('text');
		$cliRequest = new \Ophp\requests\CliRequest;
		$cliRequest->command = ltrim($command, '/');
		$cliRequest->params = explode(' ', $args);
		$cliRequest->setServerVars(['XDG_SESSION_ID' => 'slackuserid']);
		$cliServer = new \Jot\cli\CliServer;
		$cliResponse = $cliServer->getResponse($cliRequest);

		return json_decode($cliResponse->body);
	}

	public function __invoke() {
		$result = $this->getCliResult();
		$output = [];
		$output[] = '*' . htmlspecialchars($result->item->content) . '* `' . $result->item->itemId . '`';
		$belongsTo = [];
		$belongsTo[] = '_Belongs to:_';
		foreach ($result->belongsTo as $item) {
			$belongsTo[] = "- " . htmlspecialchars($item->content) . ' `' . $item->itemId . '`';
		}
		$contains = [];
		$contains[] = '_Contains:_';
		foreach ($result->contains as $item) {
			$contains[] = "- " . htmlspecialchars($item->content) . ' `' . $item->itemId . '`';
		}
		$json = json_encode([
			'text' => implode("\n", $output),
			'attachments' => [
				[
					'text' => implode("\n", $belongsTo),
					'color' => '#ff44ff',
				],
				[
					'text' => implode("\n", $contains),
					'color' => '#4444ff',
				],
			],
		]);

		return $this->newResponse()->body($json);
	}

}
