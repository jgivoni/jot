<?php

namespace Eiai;

class Item {
	/**
	 * Returns the item's content
	 */
	public function getContent() {
		
	}
	
	/**
	 * Alters the item's content
	 * This is executed immediately, no need to call save on item
	 * @param string $content
	 */
	public function setContent($content) {
		
	}
	
	/**
	 * Creates a link from this item to another item
	 * @param Item $item
	 */
	public function linkTo($item) {
		
	}
	
	/**
	 * Returns all items that this item links to
	 * @return ItemSet
	 */
	public function getLinkedItems() {
		
	}
	
	/**
	 * Returns all items that this item links to that link to the specified item
	 * @param type $itemid
	 */
	public function getLinkedItemsByLinkedItem($itemid) {
		
	}

	/**
	 * Returns all the children items that are linked to this item
	 * @return ItemSet
	 */
	public function getChildren() {
		
	}

}
