<?php

namespace Ophp;

/**
 * Constructs sql queries bit by bit
 */
abstract class SqlQueryBuilder {

	/**
	 *
	 * @var SqlCriteriaAssembler
	 */
	protected $queryAssembler;

	protected $from = array();
	protected $join = array();
	protected $where = array();
	protected $order = array();
	protected $offset = '';
	protected $limit = '';
	protected $compiledQuery = '';
	
	abstract protected function compileQuery();
	
	public function __toString() {
		return $this->getCompiledQuery();
	}
	
	public function setQueryAssembler(SqlCriteriaAssembler $sca) {
		$this->queryAssembler = $sca;
		return $this;
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
			if ($part instanceof SqlCriteriaNode) {
				$part = $part->acceptAssembler($this->queryAssembler);
			}
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
		if (!empty($part)) {
			if ($part instanceof SqlExpression) {
				$part = $part->acceptAssembler($this->queryAssembler);
			}
			if (!in_array($part, $this->order)) {
				$this->order[] = $part;	
			}
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
	
}
