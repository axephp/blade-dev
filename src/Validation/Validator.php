<?php

namespace Blade\Validation;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Validator
{


	protected $axe;

	protected $rules = [];

	protected $last_message;


	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}

	public function field($field)
	{
		$validator = new ValidationBuilder($field);

		$this->rules[$field] = $validator;

		return $validator;
	}



	public function validate(array $field)
	{

		$ret = [];
		$success = true;
		foreach ($field as $key=>$value) {
			if (isset($this->rules[$key])){
				$o = $this->rules[$key]->validate($value);
				$success = ($success && $o->status == "success");
				$ret[$key] = $o;
			}
		}

		$this->last_message = $ret;

		return $success;
	}

	public function message()
	{
		return $this->last_message;
	}

}