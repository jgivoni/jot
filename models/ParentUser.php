<?php

namespace Replanner;

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
	 * @param \Replanner\UserModel $user
	 * @return \Replanner\TaskUserModel
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