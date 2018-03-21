<?php

namespace Jot\api\controllers;

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
			$belongsTo = (array) $item->linkTo;
			$contains = (array) $item->linkFrom;
			$result = $this->getItemMapper()->deleteByModel($item);
			if ($result) {
				foreach ($belongsTo as $itemId) {
					$toItem = $this->getItemMapper()->loadByPrimaryKey($itemId);
					$result = $this->getItemMapper()->unlinkItemFrom($item, $toItem);
				}
				foreach ($contains as $itemId) {
					$fromItem = $this->getItemMapper()->loadByPrimaryKey($itemId);
					$result = $this->getItemMapper()->unlinkItemTo($fromItem, $item);
				}
			}
		} else {
			$result = false;
		}
		return $this->newResponse()->body(['result' => $result]);
	}

}
