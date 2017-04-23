<?php

namespace Blade\Validation\Rules;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Numeric
{

	public function execute($validator)
	{
		
		$var = filter_var($validator->field[1], FILTER_VALIDATE_FLOAT);

		$options = [];

		switch ($args) {
			case 'between':
				


				break;
			
			default:
				# code...
				break;
		}
		
		dump($var);

		return true;
		
	}

}