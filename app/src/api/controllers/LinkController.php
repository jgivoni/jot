<?php

namespace Replanner\api\controllers;

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
		$dba = $this->getDynamoDbDatabaseAdapter();
		$result = $dba->addSetElements('replanner-items', 'itemId', [
			'itemId' => $this->itemId,
		], [
			'to' => [$this->toId],
		]);
		$result = $dba->addSetElements('replanner-items', 'itemId', [
			'itemId' => $this->toId,
		], [
			'from' => [$this->itemId],
		]);

		return $this->newResponse()->body(['result' => $result]);
	}

}
