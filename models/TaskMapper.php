<?php

namespace Replanner;

/**
 * Model Mapper for tasks
 */
class TaskMapper extends \Ophp\DataMapper {
	/**
	 * @var array Fields in the database. Specify key if name of field in model differs
	 */
	protected $fields = array(
		'taskId' => 'task_id', 
		'title', 
		'description', 
		'createdTimestamp' => 'created_timestamp',
		'position', 
		'priority', 
		'parent'
	);
	protected $primaryKey = 'taskId';
	protected $tableName = 'task';

	/**
	 * 
	 * @return \TaskModel
	 */
	protected function newModel() {
		return new TaskModel;
	}
	
	/**
	 * 
	 * @param mixed $primaryKey
	 * @return \TaskModel
	 */
	protected function getSharedModel($primaryKey) {
		return parent::getSharedModel($primaryKey);
	}
	
	/**
	 * @param int $task_id
	 * @return TaskModel
	 */
	public function loadByPrimaryKey($task_id) {
		return parent::loadByPrimaryKey($task_id);
	}
	
	public function saveTask(TaskModel $task) {
		if (!isset($task['position'])) {
			$task['position'] = 1;
		}
		$sql = "position FROM task WHERE position = ".$task['position'];
		if (!$task->isNew()) {
			$sql .= ' AND task_id != '.$task['taskId'];
		}
		$query = new SqlDatabaseQuery($this->dba);
		if ($query->select($sql)->rewind()->current()) {
			$sql = "UPDATE `task` SET `position` = `position` + 1 WHERE `position` >= ".$task['position'].
					" AND task_id != ".$task['taskId'];
			$this->dba->query($sql);
		}
		$fields = array();
		foreach ($this->fields as $key => $name) {
			$modelField = is_numeric($key) ? $name : $key;
			$value = $task[$modelField];
			if (isset($value)) {
				if (is_string($value)) {
					$value_sql_formatted = '"'.$this->dba->escapeString($value).'"';
				} elseif (is_int($value) && preg_match('/timestamp$/', $name)) {
					$value_sql_formatted = '"'.date('Y-m-d H:i:s', $value).'"';
				} else {
					$value_sql_formatted = $value;
				}
				$fields[] = "`$name` = $value_sql_formatted";
			}
		}
		$query = new SqlDatabaseQuery($this->dba);
		$set = 'SET '.implode(',', $fields);
		if ($task->isNew()) {
			$sql = 'INTO `task` '.$set;
			$taskId = $query->insert($sql)->getInsertId();
			$task->setTaskId($taskId);
			$this->setSharedModel($task);
		} else {
			$sql = '`task` '.$set.
					' WHERE '.$this->fields[$this->primaryKey].'='.$task[$this->primaryKey];

			$query->update($sql);
		}
	}
	
	
	public function deleteTask(TaskModel $taskModel) {
		$sql = 'DELETE FROM `task` WHERE `task_id` = '.$taskModel->getTaskId();
		$this->dba->query($sql);
	}
}