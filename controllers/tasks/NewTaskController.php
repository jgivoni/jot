<?php

namespace Replanner;

class NewTaskController extends BaseController {
	/**
	 * @var TaskModel
	 */
	protected $taskModel;
	/**
	 * @var string Name of a new task
	 */
	protected $title;
	
	protected $fields;
	
	/**
	 * Creates a new controller and sets the title for a new task if given
	 */
	public function __construct($title = '') {
		parent::__construct();
		$this->title = $title;
	}
	
	/**
	 * Invokes the controller and returns a response which is one of 3 things:
	 * 1. The form from which to create a new task
	 * 2. A redirect to the view task page of the new task
	 * 3. A redirect to the form, in case it was submitted, but invalid
	 * 
	 * @return Response
	 */
	public function __invoke() {
		$this->taskModel = $this->getDataMapper('task')->newModel()->setTitle($this->title);
		$this->fields = new TaskForm($this->taskModel);
		$req = $this->getRequest();
		if ($req->isGet()) {
			return $this->showForm();
		} elseif ($req->isPost()) {
			try {
				$this->postRequest($req);
			} catch (InvalidArgumentException $e) {
				return $this->redirectToForm();
			}
			return $this->redirectToView();
		}
	}
	
	/**
	 * Returns a response containing the form from which to create a new task
	 * 
	 * @return Response
	 */
	public function showForm() {
		$content = $this->newView('task/form.html')->assign(array(
			'fields' => $this->fields,
			'mode' => 'edit'
		));
		return $this->newResponse()->body($content);
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

	/**
	 * Returns a response that redirects to the form from which to create a new item
	 * 
	 * @return Response
	 */
	public function redirectToForm() {
		$fields = $this->fields;
		return $this->newResponse()->redirect('/tasks/new/'.$this->getRequest()->getPostParam($fields->title['name']));
	}

	/**
	 * Accepts posted form input and tries to save a new task
	 * 
	 * @return null
	 */
	public function postRequest(\Ophp\HttpRequest $req) {
		$fields = $this->fields;
		$this->taskModel->setTitle($req->getPostParam($fields->title['name']));
		$this->newDataMapper('task')->saveTask($this->taskModel);
	}
}