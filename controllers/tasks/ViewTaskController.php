<?php

namespace Replanner;

use Ophp\SqlCriteriaBuilder as CB;

class ViewTaskController extends BaseController {
	
	/**
	 * @var TaskModel The current task
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
		parent::__construct();
		$this->taskId = $taskId;
	}
	
	public function __invoke() {
		try {
			$this->taskModel = $this->getTaskUserMapper()->loadByPrimaryKey($this->taskId);
			if ($this->getRequest()->getUrlPath() != $urlPath = $this->taskModel->getUrlPath()) {
				return $this->newResponse()->redirect($urlPath);
			}
			$view = $this->newView('task/view.html')->assign(array(
				'task' => $this->taskModel,
				'subtasks' => $this->getSubtasks(),
			));
		} catch (\OutOfBoundsException $e) {
			$view = $this->newView('task/notfound.html');
		}
		
		return $this->newResponse($view);
	}
	
	protected function newDocumentView() {
		$document = parent::newDocumentView();
		$document->setTitle('View task');
		return $document;
	}
	
	protected function getSubtasks() {
		$query = $this->getTaskMapper()->newSelectQuery()
				->where(CB::field('parent')->is($this->taskModel->getTaskId()));
		return $this->getTaskMapper()->loadAll($query);
	}
}