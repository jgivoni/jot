<?php

namespace Replanner;

/**
 * Model Mapper for tasks joined with user
 */
class TaskUserMapper extends TaskMapper
{
	use JoinUser;
	use JoinUserTask;
	
	protected $currentUserId;
		
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
	 * @return \Ophp\SqlQueryBuilder_Select
	 */
	public function newSelectQuery() {
		$query = parent::newSelectQuery();
		$query = $this->addJoinUser($query, '`task`.`user_id`');
		return $this->addJoinUserTask($query, '`task`.`task_id`', $this->currentUserId);
	}
	
	/**
	 * 
	 * @param array $row
	 * @return TaskUserModel
	 */
	protected function mapRowToModel($row) {
		$taskUserModel = parent::mapRowToModel($row);
		$this->addMapUser($row, $taskUserModel);
		$this->addMapUserTask($row, $taskUserModel);
		return $taskUserModel;
	}
	
	public function setCurrentUserId($currentUserId) {
		$this->currentUserId = (int) $currentUserId;
		return $this;
	}
			
}
