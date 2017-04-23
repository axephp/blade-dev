<?php

namespace Blade\Validation\Rules;

use Exception;
use Blade\Validation\ValidationBuilder;
use Blade\Validation\Rules\CommonRules;

class Characters
{
	use CommonRules;

	public function execute(ValidationBuilder $validator)
	{
		// Required
		if ($this->required($validator)) {
			return $this->required($validator);
		}

		// START DATA TYPES

		$characters = filter($validator->value, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[a-zA-Z]/")));
		if (!$characters && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-characters",
					"message"	=> "The entered value is not alphabets."
					];
		}

		// ARGS

		// END DATA TYPES

		// Common
		return $this->validateCommons($validator);
	}
}