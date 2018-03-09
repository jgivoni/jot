<?php

namespace Replanner\cli\controllers;

/**
 */
class LinkController extends CliController {

	public function __invoke() {
		$parentName = $this->getRequest()->getParam(1);
		if (!isset($parentName)) {
			$parentName = $this->getRequest()->getParam(0);
			$itemId = $_SESSION['itemId'];
		} else {
			$itemId = $this->getRequest()->getParam(0);
		}
		$parentId = $this->getItemId($parentName);
		if (!isset($parentId)) {
			$parentId = $parentName;
		}

		$success = $this->getApiResult('/link/' . $itemId . '/' . $parentId);
		
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
