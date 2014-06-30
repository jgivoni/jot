<?php

namespace Ophp;

class DbaDebugDecorator implements SqlDatabaseAdapterInterface {

	/**
	 *
	 * @var SqlDatabaseAdapterInterface
	 */
	protected $dba;
	
	public function __construct($dba) {
		$this->dba = $dba;
	}

	/**
	 * @return int
	 */
	public function getInsertId() {
		return $this->dba->getInsertId();
	}
	
	/**
	 * @return string
	 */
	public function escapeString($str) {
		return $this->dba->escapeString($str);
	}
	
	public function __call($name, $arguments) {
		return call_user_func_array(array($this->dba, $name), $arguments);
	}

	/**
	 * @param string $sql
	 * @returns DbQueryResult
	 */
	public function query($sql) {
		\FB::log($sql);
		return $this->dba->query($sql);
	}

	public function select($fields = array()) {
		$sql = $this->dba->select($fields)
				->setDba($this);
		return $sql;
	}
}