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

		$boolean = filter_var($validator->value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if ($boolean === null && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-boolean",
					"message"	=> "The entered value is not valid."
					];
		}


		if($validator->args == "true"){
			if ($boolean === false) {
				return [
						"status"	=> "error",
						"type"		=> "not-true",
						"message"	=> "You must accept before you continue."
						];
			}
		}

		// END DATA TYPES

	}
}