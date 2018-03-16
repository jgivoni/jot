<?php

namespace Replanner\models;

/**
 * @method \Replanner\models\Item loadByPrimaryKey
 */
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

	public function deleteByModel(\Ophp\Model $item) {
		return $this->dba->delete($this->tableName, $this->modelToArray($item), $this->primaryKey);
	}

	/**
	 * Saves a (new?) item
	 * 
	 * Autogenerates a new item ID if not specified
	 * 
	 * @param \Replanner\models\Item $item
	 * @param string $identity Item ID for the user creating the item
	 * @return string Item ID for the saved item
	 */
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

	public function linkItems(Item $fromItem, Item $toItem) {
		$result1 = $this->dba->addSetElements($this->tableName, [
			'itemId' => $fromItem->itemId,
				], [
			'to' => [$toItem->itemId],
		]);
		$result2 = $this->dba->addSetElements($this->tableName, [
			'itemId' => $toItem->itemId,
				], [
			'from' => [$fromItem->itemId],
		]);
		return $result1 && $result2;
	}

	public function unlinkItems(Item $fromItem, Item $toItem) {
		$result1 = $this->unlinkItemTo($fromItem, $toItem);
		$result2 = $this->unlinkItemFrom($fromItem, $toItem);
		return $result1 && $result2;
	}

	public function unlinkItemTo(Item $fromItem, Item $toItem) {
		return $this->dba->removeSetElements($this->tableName, [
					'itemId' => $fromItem->itemId,
						], [
					'to' => [$toItem->itemId],
		]);
	}

	public function unlinkItemFrom(Item $fromItem, Item $toItem) {
		return $this->dba->removeSetElements($this->tableName, [
					'itemId' => $toItem->itemId,
						], [
					'from' => [$fromItem->itemId],
		]);
	}

}
