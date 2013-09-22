<?php

namespace Replanner;

class TaskChangePositionController extends BaseController {
	protected $task_id;
	protected $taskModel;
	protected $title;
	
	function __construct($task_id) {
		parent::__construct();
		$this->task_id = $task_id;
	}
	
	public function __invoke() {
		$this->taskModel = $this->getDataMapper('task')->loadByPrimaryKey($this->task_id);
		$req = $this->getRequest();
		if ($req->isPost()) {
			try {
				$this->postRequest($req);
			} catch (InvalidArgumentException $e) {
				return $this->newResponse()->body(array('success' => false));
			}
			$taskList = $this->newView('task/list.html')->assign(array(
				'tasks' => $this->getDataMapper('task')->loadAllOrdered()
			));
			return $this->newResponse()->body(array(
				'taskList' => (string)$taskList
			));;
		} else {
			return $this->newResponse()->body("No drop position posted");
		}
	}

	public function postRequest(\Ophp\HttpRequest $req) {
		$taskMapper = $this->getDataMapper('task');
		$dropTaskId = $req->getPostParam('dropTaskId');
		if (!empty($dropTaskId)) {
			$dropTask = $taskMapper->loadByPrimaryKey($dropTaskId);
			$newPosition = $dropTask['position'];
		} else {
			$lastTask = $taskMapper->loadLast();
			$newPosition = $lastTask['position'] + 1;
		}
		$this->taskModel->setPosition($newPosition);
		$taskMapper->saveTask($this->taskModel);
	}
}