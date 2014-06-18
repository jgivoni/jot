<?php

namespace Replanner;

/**
 * Trait for joining with user
 */
trait JoinUser {

	/**
	 * 
	 * @return \Ophp\SqlQueryBuilder_Select
	 */
	public function addJoinUser(\Ophp\SqlQueryBuilder_Select $query) {
		$query->join('LEFT JOIN `user` USING (`user_id`)')
				->select('user.name as username');
		return $query;
	}

	/**
	 * 
	 * @param array $row
	 * @return \Ophp\Model
	 */
	protected function addMapUser($row, $baseModel) {
		$userModel = (new UserModel)
				->setName($row['username'])
				->setUserId($row['user_id']);
		$baseModel->setParentUser($userModel);
		return $baseModel;
	}

}
