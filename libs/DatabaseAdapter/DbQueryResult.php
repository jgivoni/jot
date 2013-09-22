<?php

namespace Ophp;

class DbQueryResult implements \Iterator {
	
	/**
	 * A function to call to fetch a row
	 * 
	 * The function must return an associated array or false when there are no more rows
	 * 
	 * @var Closure
	 */
	protected $fetchRecordFunction;
	
	/**
	 * The rows of data
	 * 
	 * The rows are lazy loaded, meaning they will only be fetched once looped through
	 * 
	 * @var array
	 */
	protected $recordSet = array();
	/**
	 * The internal pointer of the record set
	 * 
	 * @var int or null if not pointing to any row
	 */
	protected $pointer;
	
	protected $insertId;
	protected $affectedRows;
	protected $numRows;
	protected $matchedRows;

	function __construct(\Closure $fetchRecord) {
		$this->fetchRecordFunction = $fetchRecord;
		$this->rewind();
	}
	
	/**
	 * Iterator interface to provide support for foreach
	 */
	
	/**
	 * Returns the row the internal array pointer is currently pointing to
	 * 
	 * @return array or false if not pointing to any row
	 */
	public function current() {
		while (!isset($this->recordSet[$this->pointer]) && count($this->recordSet) < $this->numRows) {
			$this->fetchRecord();
		}
		return isset($this->recordSet[$this->pointer]) ? $this->recordSet[$this->pointer] : false;
	}
	
	/**
	 * Returns the key of the current row, which is identical to the pointer
	 * 
	 * @return int or null
	 */
	public function key() {
		return $this->pointer;
	}
	
	/**
	 * Advances the internal array pointer 
	 * 
	 * Chainable
	 * 
	 * @return \DbQueryResult
	 */
	public function next() {
		$this->pointer = (isset($this->pointer) && $this->pointer < $this->numRows - 1) ? $this->pointer + 1 : null;
		return $this;
	}
	
	/**
	 * Resets the array pointer to the first element
	 * 
	 * Chainable
	 * 
	 * @return \DbQueryResult
	 */
	public function rewind() {
		$this->pointer = !$this->isEmpty() ? 0 : null;
		return $this;
	}
	
	/**
	 * Checks if the current pointer position is valid
	 * 
	 * @return bool
	 */
	public function valid() {
		return isset($this->pointer);
	}
	
	/**
	 * End of iterator interface
	 */
	
	
	protected function fetchRecord() {
		$record = $this->fetchRecordFunction->__invoke();
		if ($record !== false) {
			$this->recordSet[] = $record;
		}
	}
	
	public function first() {
		return $this->rewind()->current();
	}

	public function setInsertId($id) {
		$this->insertId = $id;
		return $this;
	}
	
	/**
	 * Returns the value of the last generated AUTO_INCREMENT value of a new row created with an INSERT statement
	 * This would usually be the primary key
	 */
	public function getInsertId() {
		return $this->insertId;
	}
	
	public function getMatchedRows() {
		return $this->matchedRows;
	}
	
	public function setMatchedRows($n) {
		$this->matchedRows = $n;
		return $this;
	}
	
	public function setNumRows($n) {
		$this->numRows = $n;
		return $this;
	}
	
	public function getNumRows() {
		return $this->numRows;
	}

	public function isEmpty() {
		return $this->numRows == 0;
	}
	
}