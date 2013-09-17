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
				$e->getMessage . "\nSQL: '" . $sql . "'");
		}

		$dbQueryResult = new DbQueryResult(function() use ($result) {
					return $result->fetch();
				});
		if ($result->columnCount() > 0) {
			$dbQueryResult->setNumRows($result->rowCount());
		}

		return $dbQueryResult;
	}

	public function escapeString($str) {
		$this->connect();
		return $this->connectionLink->quote($str, \PDO::PARAM_STR);
	}

	public function getInsertId() {
		return $this->connectionLink->lastInsertId();
	}

	public function getMatchedRows() {
		$result = $this->query('SELECT FOUND_ROWS()');
		list($matchedRows) = $result->rewind()->current();
		return $matchedRows;
	}

	/**
	 * Returns a prepared query builder
	 * 
	 * Run run() on the query builder to execute the query
	 * 
	 * @param mixed array|string $fields
	 * @return \SqlQueryBuilder_Select
	 */
	public function select($fields = array()) {
		$sql = new SqlQueryBuilder_Select;
		$sql->setDba($this);
		$sql->select($fields);
		return $sql;
	}

}