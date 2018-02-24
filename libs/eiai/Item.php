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
	 * @return array
	 */
	public function getLinkedItems() {
		
	}
	
	/**
	 * Returns all items that this item links to that link to the specified item
	 * @param Item $item
	 */
	public function getLinkedItemsByLinkedItem($item) {
		
	}

	/**
	 * Returns all the children items that are linked to this item
	 * @return ItemSet
	 */
	public function getChildren() {
		
	}

	public function isLinkedTo($itemId) {
		
	}
	
	/**
	 * Tags the item with the specified tag item
	 * 
	 * Is this different from just linking to the item?
	 * Would it make sense to verify that the item to link to is indeed a tag?
	 * 
	 * @param string $itemId
	 */
	public function addTag($itemId) {
		return $this->linkTo($itemId);
	}

	/**
	 * Returns all tag items linked to by this item
	 */
	public function getTags() {
		// Get all items that this item is linked to that are linked to the "tag" item
		return $this->getLinkedItemsByLinkedItem(Tag::ITEMID_TAG);
	}

	/**
	 * Returns a tag of a specific category that this item links to
	 */
	public function getTagByCategory($itemId) {
		return $this->getLinkedItemsByLinkedItem($itemId);
	}
}
