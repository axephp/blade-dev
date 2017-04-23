<?php

namespace Blade\Validation\Rules;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Numeric
{

	protected $validator;

	function __construct($validator)
	{
		$this->validator = $validator;
	}

	public function execute($field, $args)
	{
		
		$var = filter_var($field[1], FILTER_VALIDATE_FLOAT);

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