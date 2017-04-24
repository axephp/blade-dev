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
		if ($validator->args == "formatted"){
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

		if ($validator->after) {

			$afterstamp = match_date($validator->after, $format);
			$after = new \DateTime("@$afterstamp");
					
		}

		if ($validator->before) {
			$beforestamp = match_date($validator->before, $format);
			$before = new \DateTime("@$beforestamp");
		}

		if ($validator->args != "") {
			
			switch ($validator->args) {
				case 'before':
					$interval = $today->diff($before);
					$sign = $interval->format('%R');
					if ($sign == "-") {
						return [
							"status"	=> "error",
							"type"		=> "exceeds-before",
							"message"	=> "The entered date exceeds maximum date."
							];
					}
					break;
				
				case 'after':
					$interval = $today->diff($after);
					$sign = $interval->format('%R');	
					if ($sign == "+") {
						return [
							"status"	=> "error",
							"type"		=> "below-after",
							"message"	=> "The entered date receeds mimimum date."
							];
					}
					break;

				case 'interval':
					$interval1 = $today->diff($before);
					$interval2 = $today->diff($after);
					$sign1 = $interval1->format('%R');
					$sign2 = $interval2->format('%R');
					if ($sign1 == "-" || $sign2 == "+") {
						return [
							"status"	=> "error",
							"type"		=> "below-after",
							"message"	=> "The entered date doesn't fall in the allowed interval."
							];
					}

					break;
				default:
					break;
			}
		}
			

		// END DATA TYPES
	}
}