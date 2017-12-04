<?php

namespace Eiai;

class MyCloud extends Cloud {

	use TaggableCloudTrait;

	const ITEMID_OWNER = 'owner';

	protected $owner;

	/**
	 * Construct a personalized cloud domain
	 * @param string $owner Item ID of the owner of the domain
	 */
	public function __construct($owner) {
		$this->owner = $owner;
	}

	public function createItem($content) {
		$item = parent::createItem($content);
		$item->setOwner($this->owner);
		return $item;
	}

}
