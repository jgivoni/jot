<?php

namespace Eiai;

/**
 * Object representing a subject's domain of items
 */
class UserDomain extends Domain {

	const ITEMID_TAG = 'tag';
	const ITEMID_TAGCATEGORY = 'tag_category';
	const ITEMID_OWNER = 'owner';

	public function setUser($item) {
		
	}

	protected function getUserAsObserver() {
		
	}

	protected function getUserAsOwner() {
		
	}

	/**
	 * Returns an item
	 * @param string $itemId
	 */
	public function getItem($itemId) {
		// Checks if you have permission to view this item
		$item = parent::getItem($itemId);
		if (!$item->isLinkedTo($this->getUserAsObserver())) {
			throw new \DomainException('Permission denied to retrieve item');
		}
		return $item;
	}

	/**
	 * Creates a new item with the specified content
	 * @param string $content
	 * @return Item
	 */
	public function createItem($content) {
		$item = parent::createItem($content);
		$item->linkTo($this->getuserAsOwner());
		return $item;
	}

	/**
	 * Creates a new tag item
	 * @param string $content Name of tag
	 * @return Item
	 */
	public function createTag($content) {
		$item = $this->createItem($content);
		$item->linkTo($this->getItem(self::ITEMID_TAG));
		return $item;
	}

	/**
	 * Creates a new tag category
	 * @param string $content Name of category
	 * @return Item
	 */
	public function createTagCateogry($content) {
		$item = $this->createItem($content);
		$item->linkTo($this->getItem(Tag::ITEMID_TAGCATEGORY));
		return $item;
	}

}
