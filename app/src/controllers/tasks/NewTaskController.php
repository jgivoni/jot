<?php

namespace Replanner;

class NewTaskController extends EditTaskController {
	
	/**
	 * Creates a new controller and sets the title for a new task if given
	 */
	public function __construct($title = '') {
		parent::__construct(null);
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
		$this->taskModel = $this->getTaskMapper()->newModel()
				->setTitle($this->title)
				->setUserId(1)
				->setParent($this->getRequest()->getParam('parent'));
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
	
	/**
	 * Returns a response containing the form from which to create a new task
	 * 
	 * @return Response
	 */
	public function showForm() {
		$form = $this->getTaskForm();
		$form->setValues($this->taskModel);
		$content = $this->newView('task/form.html')->assign(array(
			'form' => $form,
			'mode' => 'create'
				));
		return $this->newResponse($content);
	}

}