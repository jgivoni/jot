<?php

namespace Ophp;

class MysqlDatabaseAdapter implements SqlDatabaseAdapterInterface {

	/**
	 *
	 * @var \PDO
	 */
	protected $connectionLink;
	protected $host, $database, $user, $password;

	public function __construct($host, $database, $user, $password) {
		$this->host = $host;
		$this->database = $database;
		$this->user = $user;
		$this->password = $password;
	}

	protected function isConnected() {
		return isset($this->conn);
	}

	protected function connect() {
		if ($this->isConnected()) {
			return;
		}

		try {
			$connectionLink = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, 
					$this->user, $this->password, array(
				\PDO::ATTR_PERSISTENT => true
					)
			);
		} catch (\PDOException $e) {
			throw new \Exception("Couldn't open database connection: " . $e->getMessage());
		}

		$connectionLink->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->connectionLink = $connectionLink;
	}

	public function close() {
		if ($this->isConnected()) {
			unset($this->connectionLink);
		}
	}

	/**
	 * @param string $sql
	 * @returns DbQueryResult
	 */
	public function query($sql) {
		$this->connect();

		/* @var $result \PDOStatement */
		try {
			$result = $this->connectionLink->query((string) $sql);
		} catch (\PDOException $e) {
			throw new \Exception("Couldn't execute SQL statement: \n" .
				$e->getMessage() . "\nSQL: '" . $sql . "'");
		}
		
		$dbQueryResult = new DbQueryResult(function() use ($result) {
					return $result->fetch();
				});
		$dbQueryResult->setNumRows($result->rowCount());

		return $dbQueryResult;
	}

	public function escapeString($str) {
		$this->connect();
		return $this->connectionLink->quote($str, \PDO::PARAM_STR);
	}

	public function getInsertId() {
		return $this->connectionLink->lastInsertId();
	}

	/**
	 * Returns a prepared select query builder
	 * 
	 * Run run() on the query builder to execute the query
	 * 
	 * @param mixed array|string $fields
	 * @return SqlQueryBuilder_Select
	 */
	public function select($fields = array()) {
		$sql = new SqlQueryBuilder_Select;
		$sql->setDba($this);
		$sql->select($fields);
		return $sql;
	}
	
	/**
	 * Returns a prepared DELETE query builder
	 * 
	 * Run run() on the query builder to execute the query
	 * 
	 * @param mixed array|string $fields
	 * @return \SqlQueryBuilder_Delete
	 */
	public function delete() {
		$sql = new SqlQueryBuilder_Delete();
		$sql->setDba($this);
		return $sql;
	}
	
	/**
	 * Returns a prepared INSERT query builder
	 * 
	 * Run run() on the query builder to execute the query
	 * 
	 * @param mixed array|string $fields
	 * @return \SqlQueryBuilder_Insert
	 */
	public function insert() {
		$sql = new SqlQueryBuilder_Insert();
		$sql->setDba($this);
		return $sql;
	}
	
	/**
	 * Returns a prepared UPDATE query builder
	 * 
	 * Run run() on the query builder to execute the query
	 * 
	 * @param mixed array|string $fields
	 * @return \SqlQueryBuilder_Update
	 */
	public function update($part = null) {
		$sql = new SqlQueryBuilder_update();
		$sql->setDba($this);
		$sql->update($part);
		return $sql;
	}
}