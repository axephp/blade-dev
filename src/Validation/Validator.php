<?php

namespace Blade\Validation;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Validator
{


	protected $axe;

	protected $rules;


	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}

	public function field($field, $value='')
	{
		$validator = new ValidationBuilder([$field, $value]);

		$this->rules[$field] = $validator;

		return $validator;
	}


	public function validate($field)
	{
		if (!is_array($field)) {
			return $this->rules[$field]->validate();
		}

		$ret = []
		foreach ($field as $fld) {
			$ret[$fld] = $this->rules[$fld]->validate();
		}

		return (object)$ret;
	}

}