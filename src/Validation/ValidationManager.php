<?php

namespace Blade\Validation;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\AxE;
use Blade\Interfaces\AxE\Manager as IManager;

class ValidationManager extends Manager implements IManager
{

	function run(AxE $axe)
	{
		

		$validator = $axe->resolve(\Blade\Validation\Validator::class);

		$axe->map('validator', $validator);

	}
}
