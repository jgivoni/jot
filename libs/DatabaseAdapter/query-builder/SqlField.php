<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlField extends SqlExpression {

	/**
	 *
	 * @var string
	 */
	protected $f;

	function __construct($f) {
		$this->f = $f;
	}

	function is($v) {
		return new SqlCriteriaNodeCompare($this->f, $v, CB::IS);
	}

	function less($v) {
		return new SqlCriteriaNodeCompare($this->f, $v, CB::LESS);
	}

	public function acceptAssembler($assemblerVisitor) {
		return $assemblerVisitor->assembleField($this->f);
	}
}
