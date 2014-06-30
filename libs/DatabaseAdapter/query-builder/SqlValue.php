<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlValue extends SqlExpression {

	/**
	 *
	 * @var mixed
	 */
	protected $value;

	function __construct($value) {
		$this->value = $value;
	}

	public function acceptAssembler($assemblerVisitor) {
		return $assemblerVisitor->assembleValue($this->value);
	}
}
