<?php

namespace Ophp;

use Ophp\SqlCriteriaBuilder as CB;

/**
 * Visitor for assembling the data structure in Sql Criteria Builder
 */
class SqlCriteriaAssembler {

	const AND_ = "AND";
	const OR_ = "OR";
	const IS = "=";
	const ISNOT = "!=";
	const LESS = "<";
	const NOTLESS = ">=";
	const GREATER = ">";
	const NOTGREATER = "<=";
	const ISNULL = "IS NULL";
	const NOT = "NOT";

	protected $operationMap = array(
		CB::AND_ => self::AND_,
		CB::OR_ => self::OR_,
		CB::IS => self::IS,
		CB::ISNOT => self::ISNOT,
		CB::LESS => self::LESS,
		CB::NOTLESS => self::NOTLESS,
		CB::GREATER => self::GREATER,
		CB::NOTGREATER => self::NOTGREATER,
		CB::ISNULL => self::ISNULL,
		CB::NOT => self::NOT,
	);

	/**
	 *
	 * @var Callable 
	 */
	protected $escapeStringFunction;

	public function setEscapeStringFunction(callable $esf) {
		$this->escapeStringFunction = $esf;
		return $this;
	}

	public function assembleGroup($a, $b, $o) {
		if (!isset($this->operationMap[$o])) {
			throw new Exception('Operation not supported');
		}
		$o = $this->operationMap[$o];
		return "($a $o $b)";
	}

	public function assembleInverse($a) {
		return self::NOT . " ($a)";
	}

	public function assembleCompare($f, $v, $o) {
		return "$f $o $v";
	}

	public function assembleValue($value) {
		if (is_string($value)) {
			$value = $this->escapeStringFunction->__invoke($value);
		} elseif (!is_scalar($value)) {
			$value = '';
		}
		return $value;
	}

	public function assembleField($f) {
		return "`$f`";
	}

	public function assembleExpression($string, $replacements, $placeholder = null) {
		return preg_replace_callback('/(' . preg_quote($placeholder, '/') . '(\d+))/', function($matches) use ($replacements) {
					if (!key_exists((int) $matches[2] - 1, $replacements)) {
						throw new Exception('Not enough replacements for placeholders');
					}
					return $replacements[(int) $matches[2] - 1];
				}, $string);
	}
	
	/**
	 * 
	 * @param string $expr1
	 * @param string $expr2
	 * @return string
	 */
	public function assembleExpressionChain($expr1, $expr2) {
		return $expr1 . ' ' . $expr2;
	}

}