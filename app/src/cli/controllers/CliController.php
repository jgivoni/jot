<?php

namespace Jot\cli\controllers;

/**
 * @method \Jot\cli\CliServer getServer
 * @method \Ophp\requests\CliRequest getRequest
 */
abstract class CliController extends \Ophp\Controller {

	const OUTPUT_FORMAT_CLI_LIST_COLORIZED = '/bin/bash';
	const OUTPUT_FORMAT_PLAIN = 'json';

	public function setServer(\Ophp\Server $server) {
		parent::setServer($server);
		$sessionId = $this->getServer()->getRequest()->getServerVar('XDG_SESSION_ID');
		session_id($sessionId);
		session_start();
	}

	public function getItemId($key) {
		$userConfig = $this->getServer()->getUserConfig();
		$itemId = isset($userConfig[$key]) ? $userConfig[$key] : null;
		if (!isset($itemId)) {
			$itemId = $this->getItemFromSessionRecentItems($key);
		}
		return $itemId;
	}

	protected function getApiResult($query) {
		$apiRequest = new \Ophp\requests\HttpRequest;
		$apiRequest->url = $query;
		$apiRequest->addHeader('X-Jot-Identity', $this->getServer()->getUserConfig()['me']);
		$apiServer = new \Jot\api\ApiServer;
		$apiResponse = $apiServer->getResponse($apiRequest);

		$result = $apiResponse->body['result'];
		return $result;
	}

	protected function getOutputFormat() {
		$format = $this->getRequest()->getServerVar('SHELL');
		return isset($format) ? $format : self::OUTPUT_FORMAT_PLAIN;
	}

	protected function pushItemToSessionRecentItems($itemId, $content) {
		if (!isset($_SESSION['recentItems'])) {
			$_SESSION['recentItems'] = [];
		}
		$_SESSION['recentItems'][$itemId] = $content;
	}

	protected function getItemFromSessionRecentItems($content) {
		if (isset($_SESSION['recentItems'])) {
			$itemId = array_search($content, $_SESSION['recentItems']);
		}
		return isset($itemId) && $itemId !== false ? $itemId : null;
	}

}
