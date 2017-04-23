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

	public function field($field)
	{
		$validator = new ValidationBuilder($field);

		$this->rules[$field] = $validator;

		return $validator;
	}



	public function validate(array $field)
	{

		$ret = [];
		foreach ($field as $key=>$value) {
			dump($key);
			$ret[$key] = isset($this->rules[$key]) ? $this->rules[$key]->validate($value) : 
						(object)['type'=>'not-found', 'message'=>'Field not found!' ];
		}

		return $ret;
	}

}