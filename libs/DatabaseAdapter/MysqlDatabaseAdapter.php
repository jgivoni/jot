<?php

class MysqlDatabaseAdapter implements SqlDatabaseAdapterInterface {
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

		$connectionLink = @mysql_connect($this->host, $this->user, $this->password);
		if ($connectionLink === false) {
			throw new Exception("Couldn't open database connection: ".mysql_error());
		}
		
		mysql_query('SET NAMES "utf8"', $connectionLink);
		mysql_query('SET SQL_BIG_SELECTS = 1', $connectionLink);
		
		if (mysql_select_db($this->database, $connectionLink) === false) {
			throw new Exception("Couldn't select database: ".mysql_error($connectionLink));
		}
		$this->connectionLink = $connectionLink;
	}
	
	public function close() {
		if ($this->isConnected()) {
			mysql_close($this->connectionLink);
		}
	}
	
	/**
	 * @param string $sql
	 * @returns DbQueryResult
	 */
	public function query($sql) {
		$this->connect();

		$result = mysql_query((string)$sql, $this->connectionLink);

		if ($result === false) {
			throw new Exception("Couldn't execute SQL statement: ".mysql_error($this->connectionLink));
		}
		
		$dbQueryResult = new DbQueryResult(function() use ($result) {
			return mysql_fetch_assoc($result);
		});
		if (is_resource($result)) {
			$dbQueryResult->setNumRows(mysql_num_rows($result));
		}
		
		return $dbQueryResult;
	}
	
	public function escapeString($str) {
		$this->connect();
		return mysql_real_escape_string($str, $this->connectionLink);
	}
	
	public function getInsertId() {
		return mysql_insert_id($this->connectionLink);
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