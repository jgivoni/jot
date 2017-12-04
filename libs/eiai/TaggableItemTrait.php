<?php

namespace Eiai;

trait TaggableItemTrait {

	/**
	 * Tags the item with the specified tag item
	 * 
	 * Is this different from just linking to the item?
	 * Would it make sense to verify that the item to link to is indeed a tag?
	 * 
	 * @param string $itemId
	 */
	public function addTag($itemId) {
		
	}

	/**
	 * Returns all tag items linked to by this item
	 */
	public function getTags() {
		// Get all items that this item is linked to that are linked to the "tag" item
	}

	/**
	 * Returns a tag of a specific category that this item links to
	 */
	public function getTagByCategory($itemId) {
		return $this->getLinkedItemsByLinkedItem($itemId);
	}

}
