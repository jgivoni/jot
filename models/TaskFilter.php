<?php

namespace Replanner;

class TaskFilter extends \Ophp\ParamsFilter
{
	public function __construct()
	{
		$this->addParamFilter('description', new \Ophp\AggregateFilter(array(
//			new \Ophp\StringFilter(), // Must be a string - will be cast as string
			new \Ophp\StrMaxLengthFilter(50), // Max 50 characters
		)));

		$this->addParamFilter('title', new \Ophp\AggregateFilter(array(
//			new \Ophp\StringFilter(),
//			new \Ophp\AlphanumFilter(), // Only alphanumeric characters
			new \Ophp\RequiredFilter(), // Must have a value (other than null)
			new \Ophp\StrMaxLengthFilter(20), // Max length 20 characters
			new \Ophp\StrNotEmpty(), // Must not be an empty string
		)));

		// The 'status' field must be either 'draft' or 'published'
		$this->addParamFilter('status', new \Ophp\EnumFilter(array('draft', 'published')));

		// The 'author' field is required (must not be null)
		$this->addParamFilter('position', new \Ophp\RequiredFilter());

		// One filter only evaluated if other filter validates - and vice versa
		$this->addFilter(new \Ophp\MutualDependencyFilter(
			new \Ophp\ParamFilter('longitude', new \Ophp\RequiredFilter()), new \Ophp\ParamFilter('latitude', new \Ophp\RequiredFilter())
		));

		// How do we prevent unexpected parameters to pass the filter?
		// How to make it optional to choke on unexpected parameters?
		// How to toggle whether to validate or sanitize?
	}

}
