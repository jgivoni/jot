<?php

namespace Replanner;

/**
 * Model Mapper for user
 */
class UserMapper extends \Ophp\DataMapper
{

	/**
	 * @var array Fields in the database. Specify key if name of field in model differs
	 */
	protected $fields = array(
		'userId' => array(
			'column' => 'user_id',
			'type' => 'int',
		),
		'name' => array(
			'type' => 'string'
		),
	);
	protected $primaryKey = 'userId';
	protected $tableName = 'user';

	/**
	 * 
	 * @return TaskModel
	 */
	public function newModel()
	{
		return new UserModel;
	}

	/**
	 * 
	 * @param mixed $primaryKey
	 * @return \UserModel
	 */
	protected function getSharedModel($primaryKey)
	{
		return parent::getSharedModel($primaryKey);
	}

	/**
	 * @param int $userId
	 * @return UserModel
	 */
	public function loadByPrimaryKey($userId)
	{
		return parent::loadByPrimaryKey($taskId);
	}
		
}