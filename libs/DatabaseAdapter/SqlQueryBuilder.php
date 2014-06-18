<?php

namespace Ophp;

/**
 * Constructs sql queries bit by bit
 */
abstract class SqlQueryBuilder {
	/**
	 *
	 * @var MySqlDatabaseAdapter
	 */
	protected $dba;
	 
	protected $from = array();
	protected $join = array();
	protected $where = array();
	protected $order = array();
	protected $offset = '';
	protected $limit = '';
	protected $compiledQuery = '';
	protected $queryResult;
	
	abstract protected function compileQuery();
	
	public function __toString() {
		return $this->getCompiledQuery();
	}
	
	public function setDba(SqlDatabaseAdapterInterface $dba) {
		$this->dba = $dba;
	}
	
	protected function setCompiledQuery($str)
	{
		$this->compiledQuery = $str;
	}
	
	public function getCompiledQuery()
	{
		if (empty($this->compiledQuery))
			$this->compileQuery();
		return $this->compiledQuery;
	}

	/**
	 * 
	 * @param type $part
	 */
	public function from($part)
	{
		$this->from[] = $part;
		return $this;
	}
	
	protected function getFromPart()
	{
		$str = implode("\n", $this->from) . ' ' . implode("\n", $this->join);;
		if (empty($str)) {
			throw new Exception('From part missing');
		}
		return "FROM $str";
	}
	
	public function join($part)
	{
		$this->join[] = $part;
		return $this;
	}
	
	public function where($part)
	{
		if (!empty($part)) {
			$this->where[] = $part;
		}
		return $this;
	}

	protected function getWherePart()
	{
		$str = implode("\nAND ", $this->where);
		return !empty($str) ? "WHERE $str" : '';
	}
	
	public function orderBy($part)
	{
		if (isset($part) && !in_array($part, $this->order)) {
			$this->order[] = $part;	
		}
		return $this;
	}
	
	protected function getOrderPart()
	{
		$str = implode(", ", $this->order);
		return !empty($str) ? "ORDER BY $str" : '';
	}

	public function offset($part)
	{
		$this->offset = $part;
		return $this;
	}
	
	public function limit($part, $part2 = null)
	{
		$parts = explode(",", $part, 2);
		if (count($parts) > 1) {
			if (isset($part2)) {
				throw new Exception('Two many parts');
			}
			list($part, $part2) = $parts;
		}
		if (isset($part2)) {
			$this->offset($part);
			$this->limit = $part2;
		} else {
			$this->limit = $part;
		}
		return $this;
	}
	
	protected function getLimitPart()
	{
		if (!empty($this->limit)) {
			$str = $this->limit;
		} else {
			return "";
		}
		
		if (!empty($this->offset)) {
			$str = $this->offset . ", " . $str;
		}
			
		return "LIMIT $str";
	}
	
	/**
	 * 
	 * @return DbQueryResult
	 */
	public function run() {
		return $this->queryResult = $this->dba->query($this->getCompiledQuery());
	}
	
	public function getQueryResult() {
		return $this->queryResult;
	}
}

class SqlQueryBuilder_Select extends SqlQueryBuilder {
	const EXTRA_COUNT_TOTAL = 1;
	
	protected $select = array();
	protected $group = array();
	protected $having = array();
	protected $countMatchedRows = false;
	
	public function __construct($part = null) {
		if (isset($part)) {
			$this->select($part);
		}
	}

	protected function compileQuery()
	{
		$select = $this->getSelectPart();
		$from 	= $this->getFromPart();
		$where 	= $this->getWherePart();
		$group 	= $this->getGroupPart();
		$having = $this->getHavingPart();
		$order 	= $this->getOrderPart();
		$limit 	= $this->getLimitPart();
		$query 	= "$select\n$from\n$where\n$group\n$having\n$order\n$limit";
		
		$this->setCompiledQuery($query);
		return $query;
	}
	
	/**
	 * 
	 * @param string $part
	 * @return \Ophp\SqlQueryBuilder_Select
	 */
	public function select($part)
	// Adds a field part to a select query
	{
		if (is_array($part)) {
			foreach ($part as $p) {
				$this->select($p);
			}
		} else {
			$this->select[] = $part;
		}
		return $this;
	}

	protected function getSelectPart()
	{
		$str = implode(",\n ", $this->select);
		if (empty($str)) {
			$str = "*";
		}
		$countMatchedRowsString = $this->countMatchedRows ? 'SQL_CALC_FOUND_ROWS' : '';
		return "SELECT $countMatchedRowsString $str";
	}
	
	public function groupBy($part)
	{
		if (isset($part) && !in_array($part, $this->group)) {
			$this->group[] = $part;	
		}
		return $this;
	}
	
	protected function getGroupPart()
	{
		$str = implode(", ", $this->group);
		return !empty($str) ? "GROUP BY $str" : '';
	}
	
	public function having($part)
	{
		if (!empty($part)) {
			$this->having[] = $part;
		}
		return $this;
	}
	
	protected function getHavingPart()
	{
		$str = implode("\nAND ", $this->having);
		return !empty($str) ? "HAVING $str" : '';
	}
	
	public function countMatchedRows($count = true) {
		$this->countMatchedRows = $count;
		return $this;
	}
	
	/**
	 * 
	 * @return DbQueryResult
	 */
	public function run() {
		$result = parent::run();
		if ($this->countMatchedRows) {
			$result2 = $this->dba->query('SELECT FOUND_ROWS()');
			$matchedRows = (int) $result2->first()[0];
			$result->setMatchedRows($matchedRows);
		}
		return $result;
	}

}

class SqlQueryBuilder_Update extends SqlQueryBuilder {
	protected $update = array();
	protected $set = array();
		
	protected function compileQuery()
	{
		$update = $this->getUpdatePart();
		$set	= $this->getSetPart();
		$where 	= $this->getWherePart();
		$limit 	= $this->getLimitPart();
		$query 	= "$update\n$set\n$where\n$limit";

		$this->setCompiledQuery($query);
		return $query;
	}
	
	public function update($part)
	{
		$this->update[] = $part;
		return $this;
	}
	
	protected function getUpdatePart()
	{
		$str = implode("\n", $this->update);
		if (empty($str)) {
			throw new Exception('Update part missing');
		}
		return "UPDATE $str";
	}
	
	public function set($part)
	{
		if (!empty($part)) {
			$this->set[] = $part;
		}
		return $this;
	}
	
	protected function getSetPart()
	{
		$str = implode(",\n", $this->set);
		if (empty($str)) {
			throw new Exception('Set part missing');
		}
		return "SET $str";
	}
}

class SqlQueryBuilder_Insert extends SqlQueryBuilder {
	protected $into = array();
	protected $set = array();
		
	protected function compileQuery()
	{
		$into = $this->getIntoPart();
		$set	= $this->getSetPart();
		$query 	= "INSERT $into\n$set";

		$this->setCompiledQuery($query);
		return $query;
	}
	
	public function into($part)
	{
		$this->into[] = $part;
		return $this;
	}
	
	protected function getIntoPart()
	{
		$str = implode("\n", $this->into);
		if (empty($str)) {
			throw new Exception('Into part missing');
		}
		return "INTO $str";
	}
	
	public function set($part)
	{
		if (!empty($part)) {
			$this->set[] = $part;
		}
		return $this;
	}
	
	protected function getSetPart()
	{
		$str = implode(",\n", $this->set);
		if (empty($str)) {
			throw new Exception('Set part missing');
		}
		return "SET $str";
	}
}

class SqlQueryBuilder_Delete extends SqlQueryBuilder {
	protected function compileQuery()
	{
		$delete = $this->getDeletePart();
		$from	= $this->getFromPart();
		$where	= $this->getWherePart();
		$limit	= $this->getLimitPart();
		$query 	= "$delete\n$from\n$where\n$limit";

		$this->setCompiledQuery($query);
		return $query;
	}
	
	protected function getDeletePart()
	{
		return "DELETE";
	}
}
?>