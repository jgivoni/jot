<?php

namespace Jot;

class DeleteTaskController extends TaskController {
	protected $taskId;
	protected $taskModel;
	
	function __construct($taskId) {
		parent::__construct();
		$this->taskId = $taskId;
	}
	
	/**
	 * Returns a response that redirects to the task list after deleting
	 * the current task
	 * @return \Ophp\HttpResponse
	 */
	public function __invoke() {
		try {
			$this->taskModel = $this->getTaskMapper()->loadByPrimaryKey($this->taskId);
		} catch (\OutOfBoundsException $e) {
			$view = $this->newView('task/notfound.html');
			return $this->newResponse($view)
				->status(\Ophp\HttpResponse::STATUS_NOT_FOUND);
		}
		$this->getTaskMapper()->delete($this->taskModel);
		return $this->newResponse()->redirect('/tasks');
	}
}