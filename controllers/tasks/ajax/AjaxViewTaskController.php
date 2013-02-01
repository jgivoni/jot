<?php

namespace Replanner;

class AjaxViewTaskController extends AjaxController {
	
	/**
	 * @var TaskModel The current task
	 */
	protected $taskModel;
	
	/**
	 * @var int Current task id
	 */
	protected $task_id;
	
	/**
	 * Creates a new controller and sets the task id
	 */
	function __construct($task_id) {
		parent::__construct();
		$this->task_id = $task_id;
	}
	
	/**
	 * Invokes the controller and creates and returns the response
	 * 
	 * @return Response
	 */
	public function __invoke() {
		try {
			$this->taskModel = $this->getDataMapper('task')->loadByPrimaryKey($this->task_id);
			$content = $this->newView('task/view.html')->assign(array(
				'task' => $this->taskModel
			));
		} catch (Exception $e) {
			$content = $this->newView('task/notfound.html');
		}
		return $this->newResponse()->body(array(
			'content' => (string)$content
		));
	}
	
}