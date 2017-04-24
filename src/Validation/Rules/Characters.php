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
		$regex = "/^[a-zA-Z]*$/";

		// ARGS
		if ($validator->args == "dash"){
			$regex = "/^[a-zA-Z-_]*$/";
		}


		$characters = filter($validator->value, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$regex)));
		if (!$characters && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-valid",
					"message"	=> "The entered value is not valid."
					];
		}

		// END DATA TYPES

		// Common
		return $this->validateCommons($validator);
	}
}