<?php

namespace Jot\cli\controllers;

/**
 */
class AddController extends CliController {

	public function __invoke() {
		$content = implode(' ', $this->getRequest()->params);

		$result = $this->getApiResult('/insert/' . $content);

		$status = isset($result['status']) ? $result['status'] : null;
		$itemId = isset($result['itemId']) ? $result['itemId'] : null;
		
		$response = $this->newResponse();

		if ($status === 'success' && !empty($itemId)) {
			$_SESSION['itemId'] = $itemId;
			$response->body($itemId . " \t" . $content);
		} else {
			$message = isset($result['message']) ? $result['message'] : 'Unknown error';
			$response->error(true)->body('An error occurred executing JOT: ' . $message);
		}

		return $response;
	}

}
