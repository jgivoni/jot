<?php

namespace Replanner\controllers\tasks;

class ViewTaskController extends \Replanner\controllers\TaskController {
	
	/**
	 * @var TaskUserModel The current task
	 */
	protected $taskModel;
	
	/**
	 * @var int Current task id
	 */
	protected $taskId;
	
	/**
	 * Creates a new controller and sets the task id
	 */
	function __construct($taskId) {
		var_dump($taskId);die;
		parent::__construct();
		$this->taskId = $taskId;
	}
	
	/**
	 * Returns a response with the view of a task, or a 404 if the task could not be found
	 * @return HttpResponse
	 */
	public function __invoke() {
		try {
			$this->taskModel = $this->getTaskUserMapper()->loadByPrimaryKey($this->taskId);
			
		} catch (\OutOfBoundsException $e) {
			$view = $this->newView('task/notfound.html');
			return $this->newResponse($view)
				->status(\Ophp\HttpResponse::STATUS_NOT_FOUND);
		}
		
		if ($this->getRequest()->getUrlPath() != $urlPath = $this->taskModel->getUrlPath()) {
			return $this->newResponse()->redirect($urlPath);
		}
		$view = $this->newView('task/view.html')->assign(array(
			'task' => $this->taskModel,
			'subtasks' => $this->getSubtasks(),
			'parentTask' => $this->getParentTask(),
		));
		return $this->newResponse($view);
	}
	
	/**
	 * Returns a new document view
	 * @return \Ophp\HtmlDocumentView
	 */
	protected function newDocumentView() {
		$document = parent::newDocumentView();
		$document->setTitle('View task');
		return $document;
	}
	
	/**
	 * Returns all the subtasks of the current task
	 * @return array of TaskModel
	 */
	protected function getSubtasks() {
		return $this->getTaskMapper()->loadSubtasks($this->taskModel);
	}
	
	/**
	 * Returns the parent task of the current task, if any
	 * @return TaskModel
	 */
	protected function getParentTask() {
		try {
			$task = $this->getTaskUserMapper()->loadParent($this->taskModel);
		} catch (\OutOfBoundsException $e) {
			return null;
		}
		return $task;
	}
}