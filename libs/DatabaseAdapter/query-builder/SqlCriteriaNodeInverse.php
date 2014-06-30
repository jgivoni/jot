<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlCriteriaNodeInverse extends SqlCriteriaNode {

	/**
	 *
	 * @var SqlCriteriaNode
	 */
	protected $a;

	public function __construct($a) {
		$this->a = $a;
	}

	public function acceptAssembler($assemblerVisitor) {
		$a = $this->a->acceptAssembler($assemblerVisitor);
		return $assemblerVisitor->assembleInverse($a);
	}

}
