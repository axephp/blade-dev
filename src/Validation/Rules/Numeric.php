<?php

namespace Blade\Validation\Rules;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Numeric
{

	public function execute($validator, $args)
	{
		
		$var = filter_var($validator->field[1], FILTER_VALIDATE_FLOAT);

		$options = [];
		
		dump($var);

		return true;
		
	}

}