<?php

namespace Replanner\cli\controllers;

/**
 */
class GetController extends CliController {

	public function __invoke() {
		$itemId = $this->getRequest()->getParam(0);
		if (empty($itemId)) {
			$itemId = isset($_SESSION['itemId']) ? $_SESSION['itemId'] : null;
		}

		if (!empty($itemId)) {
			$content = $this->getApiResult('/get/' . $itemId);
		}

		$response = $this->newResponse();

		if (isset($content)) {
			$_SESSION['itemId'] = $itemId;
			$response->body($itemId . " \t" . $content);
		} else {
			$response->error(true)->body('An error occurred executing JOT');
		}

		return $response;
	}

}
