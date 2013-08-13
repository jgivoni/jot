<?php

namespace Replanner;

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
		$this->taskModel = $this->getDataMapper('task')->loadByPrimaryKey($this->task_id);
		$this->fields = new TaskForm($this->taskModel);
		$req = $this->getRequest();
		if ($req->isGet()) {
			return $this->showForm();
		} elseif ($req->isPost()) {
			try {
				$this->postRequest();
			} catch (\InvalidArgumentException $e) {
				return $this->showForm();
			}
			return $this->redirectToView();
		}
	}
	
	public function showForm() {
		$content = $this->newView('task/form.html')->assign(array(
			'fields' => $this->fields,
			'mode' => 'edit'
		));
		return $this->newResponse()->body($content);
	}

	public function redirectToView() {
		return $this->newResponse()->redirect($this->taskModel->getUrlPath());
	}
	
	public function redirectToForm() {
		return $this->newResponse()->redirect('/tasks/new/'.$this->getRequest()->getPostParam($fields->title['name']));
	}

	public function postRequest() {
		$filter = $this->getTaskFilter();
		$input = $this->getRequest()->getPostParams();
		if ($filter($input)->isValid()) {
			$params = $filter->filter();
			$this->taskModel
				->setTitle($params['title'])
				->setDescription($params['description'])
				->setPosition($params['position'])
				->setPriority($params['priority']);
			$this->getDataMapper('task')->saveTask($this->taskModel);
		} else {
			die($filter->errorMessage());
			$this->taskModel
				->setTitle($input['title'])
				->setDescription($input['description'])
				->setPosition($input['position'])
				->setPriority($input['priority']);
			$this->fields = new TaskForm($this->taskModel);
			throw new \InvalidArgumentException();
		}
		
	}
	
	/**
	 * 
	 * @return TaskFilter
	 */
	protected function getTaskFilter() {
		return isset($this->taskFilter) ? $this->taskFilter : $this->taskFilter = new TaskFilter();  
	}
}