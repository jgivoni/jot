<?php

namespace Ophp;

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

	protected function compileQuery() {
		$comments = $this->getCommentsPart();
		$select = $this->getSelectPart();
		$from = $this->getFromPart();
		$where = $this->getWherePart();
		$group = $this->getGroupPart();
		$having = $this->getHavingPart();
		$order = $this->getOrderPart();
		$limit = $this->getLimitPart();
		$query = "$comments\n$select\n$from\n$where\n$group\n$having\n$order\n$limit";

		$this->setCompiledQuery($query);
		return $query;
	}

	/**
	 * 
	 * @param string $part
	 * @return \Ophp\SqlQueryBuilder_Select
	 */
	public function select($part) {
	// Adds a field part to a select query
		if (is_array($part)) {
			foreach ($part as $p) {
				$this->select($p);
			}
		} else {
			if ($part instanceof SqlExpression) {
				$part = $part->acceptAssembler($this->queryAssembler);
			}
			$this->select[] = $part;
		}
		return $this;
	}

	protected function getSelectPart() {
		$str = implode(",\n ", $this->select);
		if (empty($str)) {
			$str = "*";
		}
		$countMatchedRowsString = $this->countMatchedRows ? 'SQL_CALC_FOUND_ROWS' : '';
		return "SELECT $countMatchedRowsString $str";
	}

	public function groupBy($part) {
		if (isset($part) && !in_array($part, $this->group)) {
			$this->group[] = $part;
		}
		return $this;
	}

	protected function getGroupPart() {
		$str = implode(", ", $this->group);
		return !empty($str) ? "GROUP BY $str" : '';
	}

	public function having($part) {
		if (!empty($part)) {
			$this->having[] = $part;
		}
		return $this;
	}

	protected function getHavingPart() {
		$str = implode("\nAND ", $this->having);
		return !empty($str) ? "HAVING $str" : '';
	}

	public function countMatchedRows($count = true) {
		$this->countMatchedRows = $count;
		return $this;
	}

	/**
	 * 
	 * @param string $part1
	 * @param string $part2
	 * @return SqlQueryBuilder_Select
	 */
	public function limit($part, $part2 = null) {
		return parent::limit($part, $part2);
	}
}
