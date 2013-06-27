<?php

namespace Replanner;

class TaskChangePositionController extends AjaxController {
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
				'tasks' => $this->getDataMapper('task')->loadAll()
			));
			return $this->newResponse()->body(array(
				'taskList' => (string)$taskList
			));;
		} else {
			return $this->newResponse()->body("No position or drop task posted");
		}
	}

	public function postRequest(\Ophp\HttpRequest $req) {
		$taskMapper = $this->getDataMapper('task');
		$dropTaskId = $req->getPostParam('dropTaskId');
		$dropTask = $taskMapper->loadByPrimaryKey($dropTaskId);
		$this->taskModel->setPosition($dropTask['position']);
		//$this->taskModel->setPriority($req->getPostParam($fields['priority']['name']));
		$taskMapper->saveTask($this->taskModel);
	}
}