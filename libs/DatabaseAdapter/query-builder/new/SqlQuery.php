<?php

namespace Ophp;

/**
 * Constructs sql queries bit by bit
 */
abstract class SqlQuery {

	protected $table;
	protected $criteria;
	/**
	 *
	 * @var SqlPagination
	 */
	protected $pagination;

	public function acceptAssembler($assemblerVisitor) {
		return $assemblerVisitor->assemble($this);
	}

	/**
	 * Adds a part to the table segment
	 * @param SqlExpression|string $part
	 */
	public function from($part) {
		if (!$part instanceof SqlExpression) {
			$part = new SqlExpression($part);
		}
		if (!isset($this->table)) {
			$this->table = $part;
		} else {
			$this->table = $this->table->chain($part);
		}
		return $this;
	}

	/**
	 * Adds a join part to the table segment
	 * @param SqlExpression|string $part
	 */
	public function join($part) {
		if (!$part instanceof SqlExpression) {
			$part = new SqlExpression($part);
		}
		return $this->from(new SqlExpressionChain(SqlExpression::JOIN, $part));
	}

	public function where($part) {
		if (!$part instanceof SqlExpression) {
			$part = new SqlExpression($part);
		}
		if (!isset($this->criteria)) {
			$this->criteria = $part;
		} else {
			$this->criteria = new SqlCriteriaNodeGroup($this->criteria, $part);
		}
		return $this;
	}

	public function offset($part) {
		$this->offset = $part;
		return $this;
	}

	public function limit($limit, $offset = null) {
		$this->pagination = new SqlPagination($limit);
		if (isset($offset)) {
			$this->pagination->setOffset($offset);
		}
		return $this;
	}

}
