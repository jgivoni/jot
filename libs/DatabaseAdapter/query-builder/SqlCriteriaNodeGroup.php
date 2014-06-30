<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlCriteriaNodeGroup extends SqlCriteriaNode {

	/**
	 *
	 * @var CB_node
	 */
	protected $a, $b;
	/**
	 *
	 * @var string
	 */
	protected $o;

	public function __construct($a, $b, $o = CB::AND_) {
		$this->a = $a;
		$this->b = $b;
		$this->o = $o;
	}

	public function acceptAssembler($assemblerVisitor) {
		$a = $this->a->acceptAssembler($assemblerVisitor);
		$b = $this->b->acceptAssembler($assemblerVisitor);
		return $assemblerVisitor->assembleGroup($a, $b, $this->o);
	}
}

