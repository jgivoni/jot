<?php

namespace Replanner\api\controllers;

class InsertController extends ApiController {

	protected $dba;
	protected $content;

	function __construct($content) {
		$this->content = $content;
		parent::__construct();
	}

	public function __invoke() {
		$dba = $this->getDynamoDbDatabaseAdapter();
		$result = $dba->insert('replanner-items', 'itemId', [
			'content' => $this->content,
		]);
		return $this->newResponse()->body(['result' => $result]);
	}

}
