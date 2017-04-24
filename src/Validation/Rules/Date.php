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
		$validDate = filter_date($validator->value);

		// ARGS
		if ($validDate && $validator->args == "formatted"){
			$validDate = date_format($validDate, $validator->dateFormat);

		}

		//$validDate = strtotime($validDate);
		//$validDate = checkdate(date("m, d, Y", $validDate));

		if (!$validDate && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-valid",
					"message"	=> "The entered date is invalid."
					];
		}

		// END DATA TYPES
	}
}