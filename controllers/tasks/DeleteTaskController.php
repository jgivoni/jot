<?php

class DeleteTaskController extends BaseController {
	protected $task_id;
	protected $taskModel;
	
	function __construct($task_id) {
		parent::__construct();
		$this->task_id = $task_id;
	}
	
	public function __invoke() {
		$this->beforeInvoke();
		$this->taskModel = $this->getDataMapper('task')->loadModelByPrimaryKey($this->task_id);
		$req = $this->getRequest();
		$this->getDataMapper('task')->deleteTask($this->taskModel);
		return $this->newResponse()->redirect('/tasks');
	}
}