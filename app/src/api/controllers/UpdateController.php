<?php

namespace Replanner\api\controllers;

class UpdateController extends ApiController {

	protected $dba;
	protected $itemId;
	protected $content;

	function __construct($itemId, $content) {
		$this->itemId = $itemId;
		$this->content = $content;
		parent::__construct();
	}

	public function __invoke() {
		$dba = $this->getDynamoDbDatabaseAdapter();
		$result = $dba->updateAttributes('replanner-items', [
			'itemId' => $this->itemId,
			'content' => $this->content,
		], 'itemId');
		return $this->newResponse()->body(['result' => $result]);
	}

}
