<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlCriteriaNodeCompare extends SqlCriteriaNode {

	/**
	 *
	 * @var SqlField
	 */
	protected $f;
	/**
	 *
	 * @var mixed
	 */
	protected $v;
	/**
	 *
	 * @var string
	 */
	protected $o;

	public function __construct($f, $v, $o = CB::IS) {
		$this->f = !($f instanceof SqlExpression) ? new SqlField($f) : $f;
		$this->v = !($v instanceof SqlExpression) ? new SqlValue($v) : $v;
		if (!isset($v) && $o == CB::IS) {
			$o = CB::ISNULL;
		}
		$this->o = $o;
	}

	public function acceptAssembler($assemblerVisitor) {
		$f = $this->f->acceptAssembler($assemblerVisitor);
		$v = $this->v->acceptAssembler($assemblerVisitor);
		return $assemblerVisitor->assembleCompare($f, $v, $this->o);
	}
}
