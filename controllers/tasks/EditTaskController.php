<?php

namespace Replanner;

class EditTaskController extends BaseController {

	protected $task_id;
	/**
	 *
	 * @var TaskModel
	 */
	protected $taskModel;
	protected $title;
	protected $taskFilter;
	protected $taskForm;

	function __construct($task_id) {
		parent::__construct();
		$this->task_id = $task_id;
	}

	public function __invoke() {
		$this->taskModel = $this->getDataMapper('task')->loadByPrimaryKey($this->task_id);
		$req = $this->getRequest();
		if ($req->isGet()) {
			return $this->showForm();
		} elseif ($req->isPost()) {
			try {
				$this->postRequest();
			} catch (\Ophp\FilterException $e) {
				return $this->showForm();
			}
			return $this->redirectToView();
		}
	}

	public function showForm() {
		$form = $this->getTaskForm();
		$form->setValues($this->taskModel);
		$content = $this->newView('task/form.html')->assign(array(
			'form' => $form,
			'mode' => 'edit'
				));
		return $this->newResponse($content);
	}

	/**
	 * Returns a response that redirects to the view task page of the current task
	 * 
	 * Called after task is successfully saved
	 * 
	 * @return Response 
	 */
	public function redirectToView() {
		return $this->newResponse()->redirect($this->taskModel->getUrlPath());
	}

	public function postRequest() {
		$filter = $this->getTaskFilter();
		$input = $this->getRequest()->getPostParams();
		try {
			$input = $filter($input);
		} catch (\Ophp\AggregateFilterException $e) {
			$this->taskModel
					->setTitle($input['title'])
					->setDescription($input['description'])
					->setPriority($input['priority']);
			$this->getTaskForm()->addException($e);
			throw $e;
		}
		
		$this->taskModel
				->setTitle($input['title'])
				->setDescription($input['description'])
				->setPriority($input['priority']);
		$this->getDataMapper('task')->saveTask($this->taskModel);
	}

	/**
	 * 
	 * @return TaskFilter
	 */
	protected function getTaskFilter() {
		return isset($this->taskFilter) ? $this->taskFilter : $this->taskFilter = new TaskFilter();
	}
	
	/**
	 * 
	 * @return TaskForm
	 */
	protected function getTaskForm() {
		return isset($this->taskForm) ? $this->taskForm : $this->taskForm = new TaskForm();
	}

}