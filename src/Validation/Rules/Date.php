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
		$regexp = "^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]|(?:Jan|Mar|May|Jul|Aug|Oct|Dec)))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2]|(?:Jan|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec))\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)(?:0?2|(?:Feb))\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9]|(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep))|(?:1[0-2]|(?:Oct|Nov|Dec)))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$";
		
		// Required
		if ($this->required($validator)) {
			return $this->required($validator);
		}

		// Common
		return $this->validateLengths($validator);

		// START DATA TYPES
		$validDate = date_create($validator->value);

		// ARGS
		if ($validator->args == "formatted"){
			$validDate = date_format($validDate, $validator->dateFormat);

		}

		$validDate = preg_match($regexp, $validDate);

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