<?php

namespace Eiai;

class Tag extends Item {

	
	/**
	 * Returns the category of this tag
	 * @return $item
	 */
	public function getTagCategory() {
		$itemSet = $this->getLinkedItemsByLinkedItem(self::ITEMID_TAGCATEGORY);
		return $itemSet->first();
	}
	
	public function isTag() {
		return $this->isLinkedTo(self::ITEMID_TAG);
	}
}
