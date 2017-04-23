<?php

namespace Blade\Validation\Rules;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Numeric
{

	public function execute($validator, $args)
	{

		$options = [];
		
		$numeric = filter($validator->value, FILTER_VALIDATE_FLOAT);
		if (!$numeric) {
			return [
					"status"	=> "error",
					"type"		=> "not-numeric",
					"message"	=> "The entered value is not a number."
					];
		}

		if ($args == "between") {
			if (!($validator->value > $validator->minValue && $validator->value < $validator->maxValue)) {
				return [
					"status"	=> "error", 
					"type"		=> "not-in-between",  
					"message"	=> "Not in between {$validator->minValue} & {$validator->maxValue}"
					];
			}
		}

	}

}