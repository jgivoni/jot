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
			$realItemId = $this->getItemId($itemId);
			if (isset($realItemId)) {
				$itemId = $realItemId;
			}

			$result = $this->getApiResult('/get/' . $itemId);
			if ($result['status'] === 'success') {
				$content = $result['item']['content'];

				$belongsTo = [];
				$contains = [];
				$belongsToIds = (array) $result['item']['belongsTo'];
				$containsIds = (array) $result['item']['contains'];
				$result = $this->getApiResult('/getbatch/' . implode(',', array_unique(array_merge($belongsToIds, $containsIds))));
				
				if ($result['status'] === 'success') {
					foreach ((array) $result['items'] as $item) {
						if (in_array($item['itemId'], $belongsToIds)) {
							$belongsTo[] = $item;
						}
						if (in_array($item['itemId'], $containsIds)) {
							$contains[] = $item;
						}
					}
				}
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
