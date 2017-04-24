<?php

namespace Blade\Validation\Rules;

use Exception;
use Blade\Validation\ValidationBuilder;
use Blade\Validation\Rules\CommonRules;

class Date
{
	use CommonRules;

	public function execute(ValidationBuilder $validator)
	{
		// Required
		if ($this->required($validator)) {
			return $this->required($validator);
		}

		// START DATA TYPES
		$format = 'Y-m-d';
		// ARGS
		if ($validator->args == "formatted"){
				$format = $validator->dateFormat;
		}

		$valid = date_validity($validator->value, $format);

		if (!$valid && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-valid",
					"message"	=> "The entered date is invalid."
					];
		}

		// END DATA TYPES
	}
}