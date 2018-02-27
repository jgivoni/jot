<?php

namespace Replanner\api\controllers;

/**
 * @method \Replanner\api\ApiServer getServer
 */
class ApiController extends \Ophp\JsonController {

	protected $dba;
	protected $itemMapper;

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

	/**
	 * 
	 * @return \Replanner\models\ItemMapper
	 */
	protected function getItemMapper() {
		if (!isset($this->itemMapper)) {
			$this->itemMapper = new \Replanner\models\ItemMapper;
			$this->itemMapper->setDba($this->getDynamoDbDatabaseAdapter());
		}
		return $this->itemMapper;
	}

	public function __invoke() {
		return $this->newResponse()->body(['result' => 'ok']);
	}

}
