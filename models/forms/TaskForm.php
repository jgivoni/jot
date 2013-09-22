<?php

namespace Replanner;

/**
 *  Not sure this should be used - check out TaskFilter instead
 * 
 */
class TaskForm extends \Ophp\Form {

	public function __construct() {
		$this->addField(
						$this->newField('title')
						->setType(\Ophp\FormField::TYPE_TEXT))
				->addField(
						$this->newField('description')
						->setType(\Ophp\FormField::TYPE_TEXTAREA))
				->addField(
						$this->newField('priority')
						->setType(\Ophp\FormField::TYPE_SELECT)
						->setOptions(array(
							new \Ophp\FormFieldOption(TaskModel::PRIORITY_HIGH, 'High'),
							new \Ophp\FormFieldOption(TaskModel::PRIORITY_NORMAL, 'Normal'),
							new \Ophp\FormFieldOption(TaskModel::PRIORITY_LOW, 'Low'),
						)));
	}

	public function setValues(TaskModel $task) {
		$this->getField('title')->setValue($task->getTitle());
		$this->getField('description')->setValue($task->getDescription());
		$this->getField('priority')->setValue($task->getPriority());
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
class TaskFormUI {

	/**
	 *
	 * @var Model The model we are trying to populate with data from a form
	 */
	protected $model;
	protected $filter;

	public function __construct($filter) {
		$this->filter = $filter;
	}

	public function getFields() {
		
	}

	public function submit($data) {
		try {
			$filter = $this->filter;
			$pureData = $filter($data);
		} catch (ValidationException $e) {
			
		}
	}

}