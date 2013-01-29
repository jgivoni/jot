<?php


class SqlDatabaseQuery {
	/**
	 *
	 * @var SqlDatabaseAdapterInterface
	 */
	protected $dba;
	
	/**
	 *
	 * @param SqlDatabaseAdapterInterface $databaseAdapter 
	 */
	public function __construct(SqlDatabaseAdapterInterface $databaseAdapter) {
		$this->dba = $databaseAdapter;
	}
	
	/**
	 *
	 * @param string $sql
	 * @return DbQueryResult
	 */
	public function query($sql) {
		return $this->dba->query($sql);
	}
	
	/**
	 *
	 * @param string $sql
	 * @return DbQueryResult
	 */
	public function insert($sql) {
		$result = $this->query('INSERT '.$sql);
		$result->setInsertId($this->dba->getInsertId());
		return $result;
	}
	
	/**
	 *
	 * @param string $sql
	 * @return DbQueryResult
	 */
	public function select($sql, $countMatchedRows = false) {
		$result = $this->query('SELECT '.($countMatchedRows ? 'SQL_CALC_FOUND_ROWS ' : '').$sql);
		//$result->setFoundRows($this->dba->getFoundRows());
		if ($countMatchedRows) {
			$result->setMatchedRows($this->dba->getMatchedRows());
		}
		return $result;
	}
	
	public function count($sql) {
		return $this->select($sql, true)->getMatchedRows();
	}
	
	/**
	 *
	 * @param string $sql
	 * @return DbQueryResult
	 */
	public function explain($sql) {
		$result = $this->query('EXPLAIN '.$sql);
		return $result;
	}
	
	/**
	 *
	 * @param string $sql
	 * @return DbQueryResult
	 */
	public function update($sql) {
		$result = $this->query('UPDATE '.$sql);
		return $result;
	}
	
	/**
	 *
	 * @param string $sql
	 * @return DbQueryResult
	 */
	public function delete($sql) {
		
	}
}