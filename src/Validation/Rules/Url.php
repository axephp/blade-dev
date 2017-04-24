<?php

namespace Blade\Validation\Rules;

use Exception;
use Blade\Validation\ValidationBuilder;
use Blade\Validation\Rules\CommonRules;

class Url
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

		$url = filter_var($validator->value, FILTER_VALIDATE_URL);
		if (!$url && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-url",
					"message"	=> "The entered value is not valid url."
					];
		}

		// END DATA TYPES

	}
}