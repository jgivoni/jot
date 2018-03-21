<?php

namespace Jot\cli\controllers;

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

		$result = $this->getApiResult('/get/' . $tagsItemId);
		if ($result['status'] === 'success') {
			$tagIds = isset($result) ? (array) $result['item']['contains'] : [];
		}
		
		if (!empty($tagIds)) {
			foreach ($tagIds as $id) {
				$result = $this->getApiResult('/get/' . $id);
				if ($result['status'] === 'success' && $result['item']['content'] === $tagName) {
					$tagId = $id;
				}
			}
		}
		if (!isset($tagId)) {
			$result = $this->getApiResult('/insert/' . $tagName);
			if ($result['status'] === 'success') {
				$tagId = $result['itemId'];
			}
			$this->getApiResult('/link/' . $tagId . '/' . $tagsItemId);
		}

		$result = $this->getApiResult('/link/' . $itemId . '/' . $tagId);
		
		$response = $this->newResponse();

		if ($result['status'] === 'success') {
			$_SESSION['itemId'] = $itemId;
			$response->body('Ok');
		} else {
			$response->error(true)->body('An error occurred executing JOT');
		}

		return $response;
	}

}
