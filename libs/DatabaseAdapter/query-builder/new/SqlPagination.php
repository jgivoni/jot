<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlPagination extends SqlExpression {
	
	/**
	 * @var int
	 */
	protected $limit;

	/**
	 *
	 * @var int
	 */
	protected $offset;

	public function __construct($limit, $offset = 0) {
		$this->limit = (int) $limit;
		$this->setOffset($offset);
	}
	
	public function setOffset($offset) {
		$this->offset = (int) $offset;
	}

	public function acceptAssembler($assemblerVisitor) {
		return $assemblerVisitor->assemblePagination($this->limit, $this->offset);
	}

}
