<?php

namespace Eiai;

trait OwnableItemTrait {

	public function setOwner($itemId) {
		return $this->linkTo($itemId);
	}

}
