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
		$dba = $this->getDynamoDbDatabaseAdapter();
		$result = $dba->delete('replanner-items', 'itemId', [
			'itemId' => $this->itemId,
		]);
		return $this->newResponse()->body(['result' => $result]);
	}

}
