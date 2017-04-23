<?php

namespace Blade\Validation\Rules;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Numeric
{

	public function execute($validator, $args)
	{

		$options = [];
		
		$var = filter_var($validator->field[1], FILTER_VALIDATE_FLOAT);

		if ($args == "between") {
			if (!($var > $validator->minValue && $var < $validator->maxValue)) {
				$var = false;
			}
		}


		return $var;
		
	}

}