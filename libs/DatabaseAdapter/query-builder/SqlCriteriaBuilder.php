<?php

// Criteria builder

namespace Ophp;

class SqlCriteriaBuilder {

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

	static function group($a, $b, $o = self::AND_) {
		return new SqlCriteriaNodeGroup($a, $b, $o);
	}

	static function both($a, $b) {
		return new SqlCriteriaNodeGroup($a, $b, self::AND_);
	}

	static function either($a, $b) {
		return new SqlCriteriaNodeGroup($a, $b, self::OR_);
	}

	static function not($a) {
		return new SqlCriteriaNodeInverse($a);
	}

	static function compare($f, $v, $o = self::IS) {
		return new SqlCriteriaNodeCompare($f, $v, $o);
	}

	static function is($f, $v) {
		return new SqlCriteriaNodeCompare($f, $v, self::IS);
	}

	static function isnot($f, $v) {
		return new SqlCriteriaNodeCompare($f, $v, self::ISNOT);
	}

	static function less($f, $v) {
		return new SqlCriteriaNodeCompare($f, $v, self::LESS);
	}

	static function notless($f, $v) {
		return new SqlCriteriaNodeCompare($f, $v, self::NOTLESS);
	}

	static function greater($f, $v) {
		return new SqlCriteriaNodeCompare($f, $v, self::GREATER);
	}

	static function notgreater($f, $v) {
		return new SqlCriteriaNodeCompare($f, $v, self::NOTGREATER);
	}

	static function isnull($f) {
		return new SqlCriteriaNodeCompare($f, null, self::ISNULL);
	}

	static function field($f) {
		return new SqlField($f);
	}
	
	static function expr($string, $replacements = null, $placeholder = null) {
		return new SqlExpression($string, $replacements, $placeholder);
	}
	
	static function value($value) {
		return new SqlValue($value);
	}

}
