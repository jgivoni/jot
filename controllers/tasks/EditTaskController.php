<?php

namespace Replanner;

class EditTaskController extends TaskController {

	protected $taskId;
	/**
	 *
	 * @var TaskModel
	 */
	protected $taskModel;
	protected $title;
	protected $taskFilter;
	/**
	 *
	 * @var TaskForm
	 */
	protected $taskForm;

	function __construct($taskId) {
		parent::__construct();
		$this->taskId = $taskId;
	}

	public function __invoke() {
		$this->taskModel = $this->getTaskMapper()->loadByPrimaryKey($this->taskId);
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
		if ($this->getRequest()->isPost()) {
			$input = $this->getRequest()->getPostParams();
			$form->setValues($input);
		} else { 
			$form->setValues($this->taskModel);
		}
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
			throw $e;
		}
		
		$this->taskModel
				->setTitle($input['title'])
				->setDescription($input['description'])
				->setPriority($input['priority'])
				->setParent($input['parent']);
		$this->getTaskMapper()->saveTask($this->taskModel);
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
		if (!isset($this->taskForm)) {
			$this->taskForm = new TaskForm();
			$parentTasks = $this->getTaskMapper()->loadAllOrdered();
			$parentOptions = [
				new \Ophp\FormFieldOption(0, 'N/A'),
			];
			foreach ($parentTasks as $task) {
				/* @var $task TaskModel */
				$parentOptions[] = new \Ophp\FormFieldOption($task->taskId, $task->getTitle());
			}
			$this->taskForm->getField('parent')
					->setOptions($parentOptions);
		}
		return $this->taskForm;
	}

	/**
	 * Returns a new document
	 * @return \Ophp\HtmlDocumentView
	 */
	protected function newDocumentView() {
		return parent::newDocumentView()
				->addJsFile($this->getServer()->getUrlHelper()->staticAssets('task/form.js'));
	}
}
