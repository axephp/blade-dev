<?php

namespace Blade\Validation\Rules;

use Exception;
use Blade\Validation\ValidationBuilder;
use Blade\Validation\Rules\CommonRules;

class Email
{
	use CommonRules;

	public function execute(ValidationBuilder $validator)
	{
		// Required
		if($this->required($validator)){
			return $this->required($validator);
		}

		// START DATA TYPES

		$mail = filter_var($validator->value, FILTER_VALIDATE_EMAIL);
		if (!$mail && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-email",
					"message"	=> "The entered valid email."
					];
		}

		// END DATA TYPES

	}
}