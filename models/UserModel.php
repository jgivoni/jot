<?php

namespace Replanner;

class UserModel extends \Ophp\Model {

	protected $userId;
	protected $name;

	public function __construct() {
	}

	public function setUserId($userId) {
		$this->userId = (int) $userId;
		return $this;
	}

	public function getUserId() {
		return $this->userId;
	}

	public function setName($name) {
		$this->name = (string) $name;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function isNew() {
		return empty($this->userId);
	}

}