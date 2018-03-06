<?php

namespace Replanner\cli\controllers;

/**
 */
class AddController extends CliController {

	public function __invoke() {
		$content = $this->getRequest()->getParam(0);

		$itemId = $this->getApiResult('/insert/' . $content);

		$response = $this->newResponse();

		if (isset($itemId)) {
			$_SESSION['itemId'] = $itemId;
			$response->body($itemId . " \t" . $content);
		} else {
			$response->error(true)->body('An error occurred executing JOT');
		}

		return $response;
	}

}
