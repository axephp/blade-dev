<?php

namespace Blade\Validation\Rules;

use Exception;
use Blade\Validation\ValidationBuilder;
use Blade\Validation\Rules\CommonRules;

class Numeric
{
	use CommonRules;

	public function execute(ValidationBuilder $validator)
	{

		//required
		$this->required();

		// START DATA TYPES

		$numeric = filter($validator->value, FILTER_VALIDATE_FLOAT);
		if (!$numeric) {
			return [
					"status"	=> "error",
					"type"		=> "not-numeric",
					"message"	=> "The entered value is not a number."
					];
		}

		//ARGS
		if ($validator->args == "exactly"){
			if (strlen($validator->value) != $this->length){
				return [
					"status"	=> "error",
					"type"		=> "not-exact-length",
					"message"	=> "The entered value doesn't match required length."
					];
			}
		}

		if ($validator->args == "between") {
			if (!($validator->value > $validator->minValue && $validator->value < $validator->maxValue)) {
				return [
					"status"	=> "error", 
					"type"		=> "not-in-between",  
					"message"	=> "Not in between {$validator->minValue} & {$validator->maxValue}"
					];
			}
		}

		// END DATA TYPES

		$this->validateCommons();

	}

}