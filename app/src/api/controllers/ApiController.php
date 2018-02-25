<?php

namespace Replanner\api\controllers;

class ApiController extends \Ophp\JsonController {
	
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
		return $this->newResponse()->body(['result' => 'ok']);
	}
}
