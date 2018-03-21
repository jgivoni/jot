<?php

namespace Jot\cli\controllers;

use Ophp\Cli\OutputFormatter as OF;

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
						$this->pushItemToSessionRecentItems($item['itemId'], $item['content']);
					}
				}
			}
		}

		$response = $this->newResponse();

		if (isset($content)) {
			$_SESSION['itemId'] = $itemId;

			$format = $this->getOutputFormat();

			if ($format === self::OUTPUT_FORMAT_CLI_LIST_COLORIZED) {
				$output = $this->getOutputCliListColorized([
					'itemId' => $itemId,
					'content' => $content,
						], $belongsTo, $contains);
			} elseif ($format === self::OUTPUT_FORMAT_PLAIN) {
				$output = json_encode([
					'item' => [
						'itemId' => $itemId,
						'content' => $content,
					],
					'belongsTo' => $belongsTo,
					'contains' => $contains,
				]);
			}
			$response->body($output);
		} else {
			$response->error(true)->body('An error occurred executing JOT');
		}

		return $response;
	}

	protected function getOutputCliListColorized($item, $belongsTo, $contains) {
		$lines = [];
		$lines[] = OF::colorize($item['itemId'], OF::COLOR_DARK_GRAY) . " \t" . OF::colorize($item['content'], OF::COLOR_YELLOW);

		$lines[] = 'Belongs to:';
		foreach ($belongsTo as $item) {
			$lines[] = OF::colorize($item['itemId'], OF::COLOR_DARK_GRAY) . " \t" . OF::colorize($item['content'], OF::COLOR_PURPLE);
		}

		$lines[] = 'Contains:';
		foreach ($contains as $item) {
			$lines[] = OF::colorize($item['itemId'], OF::COLOR_DARK_GRAY) . " \t" . OF::colorize($item['content'], OF::COLOR_LIGHT_BLUE);
		}

		return implode("\n", $lines);
	}

}
