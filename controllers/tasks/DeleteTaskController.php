<?php

namespace Replanner;

class DeleteTaskController extends BaseController {
	protected $task_id;
	protected $taskModel;
	
	function __construct($task_id) {
		parent::__construct();
		$this->task_id = $task_id;
	}
	
	public function __invoke() {
		$this->taskModel = $this->getDataMapper('task')->loadByPrimaryKey($this->task_id);
		$this->getDataMapper('task')->deleteTask($this->taskModel);
		return $this->newResponse()->redirect('/tasks');
	}
}