<?php

namespace Replanner;

class TaskUserModel extends TaskModel {
	use ParentUser;
	
	/**
	 * @var bool 
	 */
	protected $starred;
	
	public function setIsStarred($starred = true) {
		$this->starred = (bool) $starred;
	}

	/**
	 * Returns whether or not the task is starred by the current user
	 * @return bool
	 */
	public function isStarred() {
		return $this->starred;
	} 
}