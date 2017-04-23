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
		dump($numeric);
		if (!$numeric) {
			return [
					"status"	=> "error",
					"type"		=> "not-numeric",
					"message"	=> "The entered value is not a number."
					];
		}

		if ($args == "between") {
			if (!($var > $validator->minValue && $var < $validator->maxValue)) {
				return [
					"status"	=> "error", 
					"type"		=> "not-in-between",  
					"message"	=> "Not in between {$validator->minValue} & {$validator->maxValue}"
					];
			}
		}

	}

}