<?php

namespace Eiai;

/**
 * Object representing a subject's domain of items
 */
abstract class Domain {

	/**
	 * Returns an item
	 * @param string $itemId
	 */
	public function getItem($itemId) {
		$item = $this->_loadItem($itemId);
		// Injects the domain object
		$item->setDomain($this);
		return $item;
	}

	/**
	 * Creates a new item with the specified content
	 * @param string $content
	 * @return Item
	 */
	public function createItem($content) {
		$item = $this->_createNewItem();
		$item->setDomain($this);
		$item->setContent($content);
		return $item;
	}

}
