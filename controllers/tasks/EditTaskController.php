<?php

class EditTaskController extends BaseController {
	protected $task_id;
	protected $taskModel;
	protected $title;
	protected $fields;
	protected $taskFilter; 
	
	function __construct($task_id) {
		parent::__construct();
		$this->task_id = $task_id;
	}
	
	public function __invoke() {
		$this->beforeInvoke();
		$this->taskModel = $this->getDataMapper('task')->loadModelByPrimaryKey($this->task_id);
		$this->fields = new TaskForm($this->taskModel);
		$req = $this->getRequest();
		if ($req->isGet()) {
			return $this->showForm();
		} elseif ($req->isPost()) {
			try {
				$this->postRequest();
			} catch (InvalidArgumentException $e) {
				return $this->redirectToForm();
			}
			return $this->redirectToView();
		}
	}
	
	public function showForm() {
		$task_list = $this->newView('task/list.html')->assign(array(
			'tasks' => $this->getDataMapper('task')->loadTasks()
		));
		$content = $this->newView('task/form.html')->assign(array(
			'fields' => $this->fields,
			'mode' => 'edit'
		));
		$this->baseView->assign(array(
			'title' => 'Edit task',
			'head' => array(
				'<link type="text/css" rel="stylesheet" href="/static/task/form.css"/>',
				'<link type="text/css" rel="stylesheet" href="/static/task/list.css"/>',
				'<link type="text/css" rel="stylesheet" href="/static/task/view.css"/>',
				'<script type="text/javascript" src="/static/task/tasks.js"></script>'
			),
			'content' => $content,
			'index' => $task_list,
			'notifications' => 'You can edit me'
		));
		return $this->newResponse()->body($this->baseView);
	}

	public function redirectToView() {
		return $this->newResponse()->redirect($this->taskModel->getUrlPath());
	}
	
	public function redirectToForm() {
		return $this->newResponse()->redirect('/tasks/new/'.$this->getRequest()->getPostParam($fields->title['name']));
	}

	public function postRequest() {
		$params = $this->getTaskFilter()->filter($this->getRequest()->getPostParams());
		
		$this->taskModel
			//->setTitle($params->title->string)
			->setTitle($params['title'])
			->setDescription($params['description'])
			->setPosition($params['position'])
			->setPriority($params['priority']);
		$this->getDataMapper('task')->saveTask($this->taskModel);
	}
	
	protected function getTaskFilter() {
		return isset($this->taskFilter) ? $this->taskFilter : $this->taskFilter = new TaskFilter();  
	}
}