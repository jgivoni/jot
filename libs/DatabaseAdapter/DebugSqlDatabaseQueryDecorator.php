<?php

namespace Ophp;

/**
 * Provides timing, logging and meta-sql capabilities to Sql queries, to be
 * used as a decorator in development mode.
 * 
 * Can also be configured to detect duplicate queries, count affected rows etc.
 * 
 */
class DebugSqlDatabaseQueryDecorator {
	/**
	 *
	 * @var SqlDatabaseQuery
	 */
	protected $sqlDbQuery;
	public function __construct(SqlDatabaseQuery $sqlDbQuery) {
		$this->sqlDbQuery = $sqlDbQuery;
	}
	public function query($sql) {
		$result = $this->sqlDbQuery->query($sql);
		return $result;
	}
	public function select($sql) {
		$result = $this->sqlDbQuery->select($sql);
		$explain = $this->sqlDbQuery->explain('SELECT '.$sql);
		return $result;
	}
}