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
		$item = $this->getItemMapper()->loadByPrimaryKey($this->itemId);
		
		return $this->newResponse()->body(['result' => $item->content]);
	}

}
