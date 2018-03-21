<?php

namespace Jot;

class TaskModel extends \Ophp\Model {

	const PRIORITY_HIGH = 'high';
	const PRIORITY_NORMAL = 'normal';
	const PRIORITY_LOW = 'low';

	protected $taskId;
	protected $title;
	protected $description;
	protected $position;
	protected $priority;
	protected $parent;

	/**
	 *
	 * @var int Unix timestamp
	 */
	protected $createdTimestamp;

	public function __construct() {
		$this->createdTimestamp = time();
		$this->setPriority(self::PRIORITY_NORMAL);
	}

	public function setTaskId($taskId) {
		$this->taskId = (int) $taskId;
		return $this;
	}

	public function getTaskId() {
		return $this->taskId;
	}

	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setCreatedTimestamp($timestamp) {
		$this->createdTimestamp = (int) $timestamp;
		return $this;
	}

	public function getCreatedTimestamp() {
		return $this->createdTimestamp;
	}

	public function setPosition($pos) {
		$this->position = (int) $pos;
		return $this;
	}

	public function getPosition() {
		return $this->position;
	}

	public function setPriority($priority) {
		$this->priority = $priority;
		return $this;
	}

	public function getPriority() {
		return $this->priority;
	}

	public function setParent($parent) {
		$this->parent = (int) $parent;
		return $this;
	}

	public function getParent() {
		return $this->parent;
	}
	
	public function setUserId($userId) {
		$this->userId = (int) $userId;
		return $this;
	}
	
	public function getUserId() {
		return $this->userId;
	}

	public function getUrlPath() {
		$title = preg_replace('#[\'!\?]#', '', $this->title);
		$title = preg_replace('#\s+#', '-', $title);
		return '/' . rawurlencode(strtolower($title)) . '.t' . $this->taskId;
	}

	public function isNew() {
		return empty($this->taskId);
	}

}