<?php

namespace Replanner;

/**
 *  Not sure this should be used - check out TaskFilter instead
 * 
 */
class TaskForm
{

	public $title, $description, $position, $priority;

	public function __construct(TaskModel $taskModel)
	{
		$this->title = array(
			'name' => 'title',
			'value' => $taskModel->getTitle()
		);
		$this->description = array(
			'name' => 'description',
			'value' => $taskModel->getDescription()
		);
		$this->position = array(
			'name' => 'position',
			'value' => $taskModel->getPosition()
		);
		$this->priority = array(
			'name' => 'priority',
			'value' => $taskModel->getPriority(),
			'type' => 'select',
			'options' => array(
				'high', 'normal', 'low'
			)
		);
	}

	public function getElement($name)
	{
		
	}

}

/**
 * The form ui extends the model and adds data to generate a form, validate and sanitize the data and 
 * respond with feedback to the user
 * 
 * The form ui object can be passed to a view to generate the form
 * The form ui object will receive the submitted data and validate + sanitize it
 * The form ui object will populate the model if the data is valid
 * The form ui object can be questioned about validation errors
 */
class TaskFormUI
{

	/**
	 *
	 * @var Model The model we are trying to populate with data from a form
	 */
	protected $model;
	protected $filter;

	public function __construct($filter)
	{
		$this->filter = $filter;
	}

	public function getFields()
	{
		
	}

	public function submit($data)
	{
		try {
			$filter = $this->filter;
			$pureData = $filter($data);
		} catch (ValidationException $e) {
			
		}
	}

}