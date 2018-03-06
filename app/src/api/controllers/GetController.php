<?php

namespace Replanner\api\controllers;

class GetController extends ApiController {

	protected $dba;
	protected $itemId;

	function __construct($itemId) {
		$this->itemId = $itemId;
		parent::__construct();
	}

	public function __invoke() {
		$redis = $this->getServer()->newRedisCacheClient();
		$item = $redis->get($this->itemId);
		if (empty($item)) {
			$item = $this->getItemMapper()->loadByPrimaryKey($this->itemId);
			$redis->set($this->itemId, $item);
		}

		$result = isset($item) ? [
			'itemId' => $item->itemId,
			'content' => $item->content,
			'belongsTo' => (array) $item->linkTo,
			'contains' => (array) $item->linkFrom,
				] : null;
		return $this->newResponse()->body(['result' => $result]);
	}

}
