<?php

namespace Replanner;

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
		$sql = "position FROM task WHERE position = " . $task['position'];
		if (!$task->isNew()) {
			$sql .= ' AND task_id != ' . $task['taskId'];
		}
		$query = new \Ophp\SqlDatabaseQuery($this->dba);
		if ($query->select($sql)->rewind()->current()) {
			$sql = "UPDATE `task` SET `position` = `position` + 1 WHERE `position` >= " . $task['position'];
			if (!$task->isNew()) {
				$sql .= " AND task_id != " . $task['taskId'];
			}
			$this->dba->query($sql);
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
		$query = $this->dba->select()
				->orderBy('position');
		return $this->loadAll($query);
	}
	
	public function loadLast() {
		$query = $this->dba->select()
				->orderBy('position DESC');
		return $this->loadOne($query);
	}
	
}