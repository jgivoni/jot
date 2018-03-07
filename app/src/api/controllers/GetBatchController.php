<?php

namespace Replanner\api\controllers;

class GetBatchController extends ApiController {

	protected $dba;
	protected $itemIds;

	function __construct($itemIds) {
		$this->itemIds = explode(',', $itemIds);
		parent::__construct();
	}

	public function __invoke() {
		$items = $this->getItemMapper()->loadByPrimaryKeys($this->itemIds);

		$result = [];
		foreach ($items as $item) {
			$result[] = [
				'itemId' => $item->itemId,
				'content' => $item->content,
				'belongsTo' => (array) $item->linkTo,
				'contains' => (array) $item->linkFrom,
			];
		}
		return $this->newResponse()->body(['result' => $result]);
	}

}
