<?php

namespace Replanner;

class ViewTaskController extends BaseController {
	
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
	
	public function __invoke() {
		
		try {
			$this->taskModel = $this->getDataMapper('task')->loadByPrimaryKey($this->task_id);
			if ($this->getRequest()->getUrlPath() != $urlPath = $this->taskModel->getUrlPath()) {
				return $this->newResponse()->redirect($urlPath);
			}
			$view = $this->newView('task/view.html')->assign(array(
				'task' => $this->taskModel
			));
		} catch (Exception $e) {
			$view = $this->newView('task/notfound.html');
		}
		
		//$view->parent->addCssFile('/static/task/view.css');
		//$view->parent->setTitle('View task');
		return $this->newResponse()->body($view);
	}
	
}