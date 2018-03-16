<?php

namespace Replanner\cli\controllers;

/**
 */
class UpdateController extends CliController {

	public function __invoke() {
		$itemId = $this->getRequest()->getParam(0);
		$content = $this->getRequest()->params;
		$result = $this->getApiResult('/get/' . $itemId);
		if ($result['status'] === 'success') {
			array_shift($content);
		} else {
			$itemId = $_SESSION['itemId'];
		}
		$content = implode(' ', $content);
		
		$success = $this->getApiResult('/update/' . $itemId . '/' . $content);
		
		$response = $this->newResponse();

		if ($success) {
			$_SESSION['itemId'] = $itemId;
			$response->body('Ok');
		} else {
			$response->error(true)->body('An error occurred executing JOT');
		}

		return $response;
	}

}
