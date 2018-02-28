<?php

namespace Replanner\api\controllers;

class DeleteController extends ApiController {

	protected $dba;
	protected $itemId;

	function __construct($itemId) {
		$this->itemId = $itemId;
		parent::__construct();
	}

	public function __invoke() {
		$item = $this->getItemMapper()->loadByPrimaryKey($this->itemId);
		if (isset($item)) {
			$result = $this->getItemMapper()->deleteByModel($item);
		} else {
			$result = false;
		}
		return $this->newResponse()->body(['result' => $result]);
	}

}
