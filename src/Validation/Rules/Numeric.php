<?php

namespace Blade\Validation\Rules;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Numeric
{


	public function execute($field, $args)
	{
		
		dump($field);
		dump($args);

		return true;
		
	}

}