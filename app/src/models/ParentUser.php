<?php

namespace Jot;

/**
 * Trait for adding support for a parent user model into a model
 */
trait ParentUser {

	/**
	 *
	 * @var UserModel
	 */
	protected $parentUserModel;

	/**
	 * 
	 * @param \Jot\UserModel $user
	 * @return \Jot\TaskUserModel
	 */
	public function setParentUser(UserModel $user) {
		$this->parentUserModel = $user;
		return $this;
	}

	/**
	 * 
	 * @return UserModel
	 */
	public function getParentUser() {
		return $this->parentUserModel;
	}
}