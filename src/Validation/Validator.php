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



	public function validate(array $field)
	{

		$ret = [];
		foreach ($field as $key=>$value) {
			$ret[$key] = isset($this->rules[$key]) ? $this->rules[$key]->validate() : 
						(object)['type'=>'not-found', 'message'=>'Field not found!' ];
		}

		return $ret;
	}

}