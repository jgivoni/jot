<?php

namespace Replanner\api\controllers;

class InsertController extends ApiController {
	
	protected $dba;
	
	/**
	 * 
	 * @return \Ophp\dba\DynamoDbDatabaseAdapter
	 */
	protected function getDynamoDbDatabaseAdapter() {
		if (!isset($this->dba)) {
			$this->dba = $this->getServer()->newDynamoDbDatabaseAdapter('replanner');
		}
		return $this->dba;
	}

	public function __invoke() {
		$dba = $this->getDynamoDbDatabaseAdapter();
		$result = $dba->insert('item', [
			'domain' => 'replanner',
			'item_id' => 'abcdef',
			'content' => 'testwow',
		]);
		return $this->newResponse()->body(['result' => $result]);
	}
}
