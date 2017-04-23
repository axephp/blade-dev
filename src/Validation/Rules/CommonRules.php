<?php

namespace Blade\Validation\Rules;

use Exception;

trait CommonRules
{


	protected function required($validator)
	{
		if ($validator->required == true){
			if ($validator->value == ''){
				return [
					"status"	=> "error",
					"type"		=> "required",
					"message"	=> "The value is required."
					];
			}
		}
	}

	protected function validateCommons()
	{
		# code...
	}
}