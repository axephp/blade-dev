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
		$format = 'YYYY-M-D';
		// ARGS
		if ($validator->args == "formatted"){
				$format = $validator->dateFormat;
		}

		$valid = match_date($validator->value, $format);

		if (!$valid && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-valid",
					"message"	=> "The entered date is invalid."
					];
		}

		if ($validator->args == "after") {
			$datetime1 = date_create($valid);
			$datetime2 = date_create($valid);
			$interval = date_diff($datetime1, $datetime2);
			
		}

		

		// END DATA TYPES
	}
}