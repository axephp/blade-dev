<?php

namespace Blade\Validation\Rules;

use Exception;
use Blade\Validation\ValidationBuilder;
use Blade\Validation\Rules\CommonRules;

class Date
{
	use CommonRules;

	public function execute(ValidationBuilder $validator)
	{
		// Required
		if ($this->required($validator)) {
			return $this->required($validator);
		}

		// START DATA TYPES
		$format = 'YYYY-M-D';
		// ARGS
		if ($validator->dateFormat){
				$format = $validator->dateFormat;
		}

		$valid = match_date($validator->value, $format);

		if ($valid === false && $validator->value != '') {
			return [
					"status"	=> "error",
					"type"		=> "not-valid",
					"message"	=> "The entered date is invalid."
					];
		}

		$today = new \DateTime("@$valid");
		$signBefore = "";
		$signAfter = "";
		
		if ($validator->after) {

			$afterstamp = match_date($validator->after, $format);
			$after = new \DateTime("@$afterstamp");
			$intervalAfter = $today->diff($before);
			$signAfter = $interval->format('%R');
					
		}

		if ($validator->before) {
			$beforestamp = match_date($validator->before, $format);
			$before = new \DateTime("@$beforestamp");
			$intervalBefore = $today->diff($after);
			$signBefore = $interval->format('%R');
		}


				
		if ($signBefore == "-") {
			return [
				"status"	=> "error",
				"type"		=> "exceeds-before",
				"message"	=> "The entered date exceeds maximum date."
				];
		}

		if ($signAfter == "+") {
			return [
				"status"	=> "error",
				"type"		=> "below-after",
				"message"	=> "The entered date receeds mimimum date."
				];
		}
		
		// END DATA TYPES
	}
}