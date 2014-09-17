<?php

namespace Replanner;

class TaskFilter extends \Ophp\ParamsFilter
{
	public function __construct()
	{
		$this->addParamFilter('title', new \Ophp\AggregateFilter(array(
			new \Ophp\IssetFilter(), // Must have a value (null is not a value)
			new \Ophp\StringFilter(), // Must be a valid string
			new \Ophp\StrMaxLengthFilter(64), // Max length 64 characters
//			new \Ophp\StrNotEmpty(), // Must not be an empty string
		)));

		$this->addParamFilter('description', new \Ophp\DependencyFilter(
			new \Ophp\IssetFilter(), new \Ophp\AggregateFilter(array(
			new \Ophp\StringFilter('UTF-8'),
			new \Ophp\StrTrimFilter(),
			new \Ophp\StrMaxLengthFilter(1000), // Max 1000 characters
		))));

		$this->addParamFilter('priority', new \Ophp\EnumFilter(array(
			TaskModel::PRIORITY_HIGH, 
			TaskModel::PRIORITY_NORMAL,
			TaskModel::PRIORITY_LOW,
		)));
		
		$this->addParamFilter('parent', new \Ophp\IntegerFilter());

		// How to toggle whether to validate or sanitize?
	}

}
