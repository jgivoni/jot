<?php

namespace Eiai;

trait TaggableCloudTrait {

	public function createTag($content) {
		$item = $this->createItem($content);
		$item->linkTo(Tag::ITEMID_TAG);
		return $item;
	}

	public function createTagCateogry($content) {
		$item = $this->createItem($content);
		$item->linkTo(Tag::ITEMID_TAGCATEGORY);
		return $item;
	}

}
