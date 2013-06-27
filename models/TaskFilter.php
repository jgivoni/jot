<?php

namespace Replanner;

class TaskFilter extends \Ophp\ParamsFilter
{
	public function __construct()
	{
		$this->addParamFilter('description', new \Ophp\AggregateFilter(array(
			/**
			 * 1. Ignore if not set (optional-filter?)
			 * 2. Cast to string (filter)
			 * 3. Convert encoding??? (filter)
			 * 4. Trim (filter)
			 * 5. Check max. length (encoding?) (validator)
			 */
			new \Ophp\DependencyFilter(new \Ophp\IssetFilter(), new \Ophp\AggregateFilter(array(
				new \Ophp\StringFilter('UTF-8'),
				new \Ophp\TrimStringFilter(),
				new \Ophp\ValidationFilter(
					new \Ophp\StrMaxLengthFilter(50) // Max 50 characters
				),
			))),
		)));

		$this->addParamFilter('title', new \Ophp\AggregateFilter(array(
			/**
			 * 1. Cast to string - convert encoding??? (filter) 
			 * 2. Trim (filter)
			 * 3. Check not empty (validator)
			 * 4. Check max. length (validator)
			 */
//			new \Ophp\StringFilter(),
//			new \Ophp\AlphanumFilter(), // Only alphanumeric characters
			new \Ophp\RequiredFilter(), // Must have a value (other than null)
			new \Ophp\StrMaxLengthFilter(20), // Max length 20 characters
//			new \Ophp\StrNotEmpty(), // Must not be an empty string
		)));

		// The 'status' field must be either 'draft' or 'published'
		/**
		 * 1. Set default if not set (filter)
		 * 2. Cast to string - encoding? (filter)
		 * 3. Trim (filter)
		 * 4. Check against enums (validator)
		 */
		$this->addParamFilter('status', new \Ophp\EnumFilter(array('draft', 'published')));

		// The 'position' field is required (must not be null)
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
