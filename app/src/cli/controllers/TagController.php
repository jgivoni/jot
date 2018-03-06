<?php

namespace Replanner\cli\controllers;

/**
 */
class TagController extends CliController {

	public function __invoke() {
		$tagsItemId = $this->getItemId('tag');
		
		$tagName = $this->getRequest()->getParam(1);
		if (!isset($tagName)) {
			$tagName = $this->getRequest()->getParam(0);
			$itemId = $_SESSION['itemId'];
		} else {
			$itemId = $this->getRequest()->getParam(0);
		}

		$tagIds = $this->getApiResult('/query/' . $tagName . '->:' . $tagsItemId);
		
		if (!empty($tagIds)) {
			$tagId = $tagIds[0];
		} else {
			$tagId = $this->getApiResult('/insert/' . $tagName);
			$this->getApiResult('/link/' . $tagId . '/' . $tagsItemId);
		}

		$success = $this->getApiResult('/link/' . $itemId . '/' . $tagId);
		
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
