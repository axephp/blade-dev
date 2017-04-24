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

	protected function validateLengths($validator)
	{
		if ($validator->length) {
			if (strlen($validator->value) != $validator->length){
				return [
					"status"	=> "error",
					"type"		=> "not-exact-length",
					"message"	=> "The entered value doesn't match required length."
					];
			}
		}

		if ($validator->minLength) {
			if (strlen($validator->value) < $validator->minLength ) {
				return [
					"status"	=> "error",
					"type"		=> "under-min-length",
					"message"	=> "The entered value is smaller than required length."
					];
			}
		}

		if ($validator->maxLength) {
			if (strlen($validator->value) > $validator->maxLength ) {
				return [
					"status"	=> "error",
					"type"		=> "exceeds-max-length",
					"message"	=> "The entered value is greater than required length."
					];
			}
		}
	}
}