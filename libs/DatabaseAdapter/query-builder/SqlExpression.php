<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

class SqlExpression {

	const JOIN = 1;
	
	/**
	 * A string with placeholders
	 * @var string
	 */
	protected $string;

	/**
	 *
	 * @var array Mixed
	 */
	protected $replacements = [];

	/**
	 * The placeholder token string
	 * @var string
	 */
	protected $placeholder;

	function __construct($string, $replacements = null, $placeholder = null) {
		$this->string = $string;
		if (isset($replacements)) {
			$this->replacements = is_array($replacements) ? $replacements : array($replacements);
		}
		$this->placeholder = isset($placeholder) ? $placeholder : '%';
		foreach ($this->replacements as &$r) {
			if (!($r instanceof SqlExpression)) {
				$r = CB::value($r);
			}
		}
	}

	public function acceptAssembler($assemblerVisitor) {
		$replacements = array_map(function($r) use ($assemblerVisitor) {
					return $r->acceptAssembler($assemblerVisitor);
				}, $this->replacements);
		return $assemblerVisitor->assembleExpression($this->string, $replacements, $this->placeholder);
	}
	
	/**
	 * Returns an expression consisting of this one followed by another one
	 * @param \Ophp\SqlExpression $expr
	 */
	public function chain(SqlExpression $expr) {
		return new SqlExpressionChain($this, $expr);
	}

}
