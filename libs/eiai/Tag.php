<?php

namespace Eiai;

class Tag extends Item {

	const ITEMID_TAG = 'tag';
	const ITEMID_TAGCATEGORY = 'tag_category';

	/**
	 * Returns the category of this tag
	 * @return $item
	 */
	public function getTagCategory() {
		$itemSet = $this->getLinkedItemsByLinkedItem(self::ITEMID_TAGCATEGORY);
		return $itemSet->first();
	}
}
