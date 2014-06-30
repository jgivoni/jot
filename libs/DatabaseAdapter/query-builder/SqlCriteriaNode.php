<?php
namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

abstract class SqlCriteriaNode {
	public function or_($b) {
		return new SqlCriteriaNodeGroup($this, $b, CB::OR_);
	}
	
	public function and_($b) {
		return new SqlCriteriaNodeGroup($this, $b, CB::AND_);
	}
	
/*	public function __toString() {
		return $this->acceptAssembler($this->dba->getCriteriaAssembler());
	}*/
	
	public function acceptAssembler($assemblerVisitor) {
		return $assemblerVisitor->assemble($this);
	}
}

/*
  group(a, b, o) // a o b // o: AND/OR
  both(a, b) // a AND b
  either(a, b) // a OR b
  compare(f, v, o) // f o v // o: IS/ISNOT/LESS/GREATER/NOTLESS/NOTGREATER
  is(f, v) // f = v
  isnot(f, v) // f != v
  not(a) // NOT (a)
  less(f, v) // f < v
  greater(f, v) // f > v
  notless(f, v) // f >= v
  notgreater(f, v) // f <= v
  isnull(f) // f IS NULL
 */