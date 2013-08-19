<?php

namespace Replanner;

class TaskFilter extends \Ophp\ParamsFilter
{
	public function __construct()
	{
		$this->addParamFilter('title', new \Ophp\AggregateFilter(array(
			new \Ophp\IssetFilter(), // Must have a value (null is not a value)
			new \Ophp\StringFilter(), // Must be a valid string
			new \Ophp\StrMaxLengthFilter(20), // Max length 20 characters
//			new \Ophp\StrNotEmpty(), // Must not be an empty string
		)));

		$this->addParamFilter('description', new \Ophp\DependencyFilter(
			new \Ophp\IssetFilter(), new \Ophp\AggregateFilter(array(
			new \Ophp\StringFilter('UTF-8'),
			new \Ophp\StrTrimFilter(),
			new \Ophp\StrMaxLengthFilter(10), // Max 50 characters
		))));

		$this->addParamFilter('position', new \Ophp\IntegerFilter());

		$this->addParamFilter('priority', new \Ophp\EnumFilter(array('high', 'normal',
			'low')));

		// How to toggle whether to validate or sanitize?
	}

}
