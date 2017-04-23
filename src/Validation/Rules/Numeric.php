<?php

namespace Blade\Validation\Rules;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Numeric
{

	public function execute($validator, $args)
	{

		$options = [];
		
		$var = filter_var($validator->value, FILTER_VALIDATE_FLOAT);

		if ($args == "between") {
			if (!($var > $validator->minValue && $var < $validator->maxValue)) {
				return (object)["type"=>"not-in-between", "message"=>"Not in between {$validator->minValue} & {$validator->maxValue}"];
			}
		}

		return $var;
		
	}

}