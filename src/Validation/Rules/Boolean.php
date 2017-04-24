<?php

namespace Blade\Validation\Rules;

use Exception;
use Blade\Validation\ValidationBuilder;
use Blade\Validation\Rules\CommonRules;

class Boolean
{
	use CommonRules;

	public function execute(ValidationBuilder $validator)
	{
		// Required
		if($this->required($validator)){
			return $this->required($validator);
		}

		// START DATA TYPES

		// ARGS
		// none

		$boolean = filter($validator->value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if ($boolean === null && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-boolean",
					"message"	=> "The entered value is not valid."
					];
		}

		// END DATA TYPES

	}
}