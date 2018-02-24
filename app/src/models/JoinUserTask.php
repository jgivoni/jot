<?php

namespace Replanner;

/**
 * Trait for joining with user_task
 * 
 * user_task is the table that holds info about the relationship between the
 * current user and the current task
 */
trait JoinUserTask {

	/**
	 * Returns the specified query, joined with the user_task table,
	 * selecting starred
	 * @return \Ophp\SqlQueryBuilder_Select
	 */
	public function addJoinUserTask(\Ophp\SqlQueryBuilder_Select $query, $onColumn, $currentUserId) {
		$query->join('LEFT JOIN `user_task` ON `user_task`.`task_id` = ' . $onColumn . 
				' AND `user_task`.`user_id` = ' . (int) $currentUserId)
				->select('user_task.starred AS starred');
		return $query;
	}

	/**
	 * Returns the specified model, populated with the starred info
	 * @param array $row
	 * @param TaskModel $baseModel The model to link with
	 * @return \Ophp\Model
	 */
	protected function addMapUserTask($row, $baseModel) {
		$baseModel->setIsStarred($row['starred']);
		return $baseModel;
	}

}
