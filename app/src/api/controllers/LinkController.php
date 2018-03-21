<?php

namespace Jot\api\controllers;

class LinkController extends ApiController {

	protected $dba;
	protected $itemId;
	protected $toId;

	function __construct($itemId, $toId) {
		$this->itemId = $itemId;
		$this->toId = $toId;
		parent::__construct();
	}

	public function __invoke() {
		$fromItem = $this->getItemMapper()->loadByPrimaryKey($this->itemId);
		$toItem = $this->getItemMapper()->loadByPrimaryKey($this->toId);
		if (isset($fromItem) && isset($toItem)) {
			$status = $this->getItemMapper()->linkItems($fromItem, $toItem);
		} else {
			$status = false;
		}
		
		$result = [
				'status' => $status ? 'success' : 'error',
		];

		return $this->newResponse()->body(['result' => $result]);
	}

}
