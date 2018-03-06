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
			$result = $this->getApiResult('/get/' . $itemId);
			$content = isset($result) ? $result['content'] : null;
			$belongsToIds = isset($result) ? (array) $result['belongsTo'] : [];
			$belongsTo = [];
			foreach ($belongsToIds as $itemId) {
				$belongsTo[] = $this->getApiResult('/get/' . $itemId);
			}
			$contains = [];
			$containsIds = isset($result) ? (array) $result['contains'] : [];
			foreach ($containsIds as $itemId) {
				$contains[] = $this->getApiResult('/get/' . $itemId);
			}
		}

		$response = $this->newResponse();

		if (isset($content)) {
			$_SESSION['itemId'] = $itemId;
			$lines = [];
			$lines[] = $itemId . " \t" . $content;
			foreach ($belongsTo as $item) {
				$lines[] = "-> \t" . $item['itemId'] . " \t" . $item['content'];
			}
			foreach ($contains as $item) {
				$lines[] = "<- \t" . $item['itemId'] . " \t" . $item['content'];
			}
			$response->body(implode("\n", $lines));
		} else {
			$response->error(true)->body('An error occurred executing JOT');
		}

		return $response;
	}

}
