<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlExpressionChain extends SqlExpression {

	/**
	 *
	 * @var SqlExpression
	 */
	protected $expr1, $expr2;

	function __construct(SqlExpression $expr1, SqlExpression $expr2) {
		$this->expr1 = $expr1;
		$this->expr2 = $expr2;
	}

	public function acceptAssembler(SqlCriteriaAssembler $assemblerVisitor) {
		$expr1 = $this->expr1->acceptAssembler($assemblerVisitor);
		$expr2 = $this->expr2->acceptAssembler($assemblerVisitor);
		return $assemblerVisitor->assembleExpressionChain($expr1, $expr2);
	}
	
}
