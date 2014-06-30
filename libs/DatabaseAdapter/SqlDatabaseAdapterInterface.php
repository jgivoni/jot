<?php

namespace Ophp;

interface SqlDatabaseAdapterInterface {
	/**
	 * @param string $sql
	 * @return DbQueryResult
	 */
	public function query($sql);
	/**
	 * @return int
	 */
	public function getInsertId();
	
	/**
	 * @return string
	 */
	public function escapeString($str);
}