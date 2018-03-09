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

		$resultItems = [];
		foreach ($items as $item) {
			$resultItems[] = [
				'itemId' => $item->itemId,
				'content' => $item->content,
				'belongsTo' => (array) $item->linkTo,
				'contains' => (array) $item->linkFrom,
			];
		}
		$result = [
			'status' => 'success',
			'items' => $resultItems,
		];
		return $this->newResponse()->body(['result' => $result]);
	}

}