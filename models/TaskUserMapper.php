<?php

namespace Replanner;

/**
 * Model Mapper for tasks joined with user
 */
class TaskUserMapper extends TaskMapper
{
	use JoinUser;
	
	/**
	 * 
	 * @return TaskUserModel
	 */
	public function newModel()
	{
		return new TaskUserModel;
	}

	/**
	 * 
	 * @param mixed $primaryKey
	 * @return TaskUserModel
	 */
	protected function getSharedModel($primaryKey)
	{
		return parent::getSharedModel($primaryKey);
	}

	/**
	 * @param int $taskId
	 * @return TaskUserModel
	 */
	public function loadByPrimaryKey($taskId)
	{
		return parent::loadByPrimaryKey($taskId);
	}
	
	/**
	 * 
	 * @return array Of TaskUserModel
	 */
	public function newQuery() {
		$query = parent::newQuery();
		return $this->addJoinUser($query);
	}
	
	/**
	 * 
	 * @param array $row
	 * @return TaskUserModel
	 */
	protected function mapRowToModel($row) {
		$taskUserModel = parent::mapRowToModel($row);
		$this->addMapUser($row, $taskUserModel);
		return $taskUserModel;
	}
}
