<?php

namespace Replanner;

/**
 * Trait for joining with user
 */
trait JoinUser {

	/**
	 * Returns the specified query, joined with the user table,
	 * selecting username
	 * @return \Ophp\SqlQueryBuilder_Select
	 */
	public function addJoinUser(\Ophp\SqlQueryBuilder_Select $query) {
		$query->join('LEFT JOIN `user` USING (`user_id`)')
				->select('user.name as username');
		return $query;
	}

	/**
	 * Returns the specified model, linked to a model for the parent user
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
