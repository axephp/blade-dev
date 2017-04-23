<?php

namespace Blade\Validation\Rules;

use Exception;

trait CommonRules
{


	protected function required($validator)
	{
		if ($validator->required == true){
			if (empty($validator->value) || $validator->value == ''){
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