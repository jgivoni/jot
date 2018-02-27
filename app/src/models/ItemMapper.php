<?php

namespace Replanner\models;

class ItemMapper extends \Ophp\NoSqlDataMapper {

	protected $tableName = 'replanner-items';
	protected $primaryKey = 'itemId';
	protected $fields = [
		'itemId' => [
			'type' => 'string',
		],
		'content' => [
			'type' => 'string'
		],
		'linkTo' => [
			'column' => 'to',
			'type' => 'array',
		],
		'linkFrom' => [
			'column' => 'from',
			'type' => 'array',
		],
	];

	public function newModel() {
		return new Item;
	}

	public function count($query) {
		return 1;
	}

	public function deleteByModel(\Ophp\Model $model) {
		;
	}

	public function save(Item $item) {
		if (!$item->getItemId()) {
			$item->setItemId($this->getUniqueId());
		}
		if ($this->dba->insert($this->tableName, $this->modelToArray($item), $this->primaryKey)) {
			return $item->itemId;
		} // else try again...
	}

	public function getUniqueId($length = 13) {
		$bytes = ceil($length * 0.625);
		return substr(base_convert(bin2hex(random_bytes($bytes)), 16, 36), 0, $length);
	}
}
