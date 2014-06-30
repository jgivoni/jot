<?php

namespace Replanner;

use Ophp\SqlCriteriaBuilder as CB;

/**
 * Model Mapper for tasks
 */
class TaskMapper extends \Ophp\DataMapper
{

	/**
	 * @var array Fields in the database. Specify key if name of field in model differs
	 */
	protected $fields = array(
		'taskId' => array(
			'column' => 'task_id',
			'type' => 'int',
		),
		'title' => array(
			'type' => 'string'
		),
		'description' => array(
			'type' => 'string'
		),
		'createdTimestamp' => array(
			'column' => 'created_timestamp',
			'type' => 'timestamp',
		),
		'position' => array(
			'type' => 'int',
		),
		'priority' => array(
			'type' => 'string'
		),
		'parent' => array(
			'type' => 'int',
		),
		'userId' => array(
			'column' => 'user_id',
			'type' => 'int',
		)
	);
	protected $primaryKey = 'taskId';
	protected $tableName = 'task';

	/**
	 * 
	 * @return TaskModel
	 */
	public function newModel()
	{
		return new TaskModel;
	}

	/**
	 * 
	 * @param mixed $primaryKey
	 * @return \TaskModel
	 */
	protected function getSharedModel($primaryKey)
	{
		return parent::getSharedModel($primaryKey);
	}

	/**
	 * @param int $taskId
	 * @return TaskModel
	 */
	public function loadByPrimaryKey($taskId)
	{
		return parent::loadByPrimaryKey($taskId);
	}

	public function saveTask(TaskModel $task)
	{
		if (!isset($task['position'])) {
			$task['position'] = 1;
		}
		// Find out if any other tasks are occupying the position of this task
		$query = $this->dba->select(CB::field('position'))
				->from("`task`")
				->where(CB::is('position', $task['position']));
		if (!$task->isNew()) {
			$query->where(CB::isnot('task_id', $task['taskId']));
		}
		if ($query->run()->getNumRows() > 0) {
			// Move all tasks from this position and beyond to make room for this task
			$criteria = CB::notless('position', $task['position']);
			if (!$task->isNew()) {
				$criteria = $criteria->and_(CB::isnot('task_id', $task['taskId']));
			}
			$this->dba->update("`task`")
					->set("`position` = `position` + 1")
					->where($criteria)
					->run();
		}
		$fields = array();
		foreach ($this->fields as $modelField => $config) {
			$value = $task->$modelField;
			$name = isset($config['column']) ? $config['column'] : $modelField;
			if (isset($value)) {
				switch ($config['type']) {
					case 'int': isset($v) || $v = (int) $value;
					case 'string': isset($v) || $v = $this->dba->escapeString($value);
					case 'timestamp': isset($v) || $v = '"' . date('Y-m-d H:i:s', $value) . '"';
					default: isset($v) || $v = $value;
						$value_sql_formatted = $v;
						unset($v);
				}
				$fields[] = "`$name` = $value_sql_formatted";
			}
		}
		$sql = $task->isNew() ? 
			$this->dba->insert()->into('`task`') : 
			$this->dba->update('`task`')->where($this->getPkColumn() . '=' . $task[$this->primaryKey]);
		$result = $sql->set(implode(',', $fields))
			->run();
		
		if ($task->isNew()) {
			$taskId = $this->dba->getInsertId();
			$task->setTaskId($taskId);
			$this->setSharedModel($task);
		}
	}

	/**
	 * Deletes a task
	 * 
	 * @param \Replanner\TaskModel $taskModel
	 */
	public function delete(TaskModel $taskModel)
	{
		return $this->deleteByModel($taskModel);
	}

	public function loadAllOrdered() {
		$query = $this->newQuery()
				->orderBy(CB::field('position'))
				->countMatchedRows();

		return $this->loadAll($query);
	}
	
	public function loadLast() {
		$query = $this->newQuery()
				->orderBy(CB::expr('%1 DESC', CB::field('position')));
		return $this->loadOne($query);
	}
	
}