<?php

namespace Blade\Validation;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Validator
{


	protected $axe;

	protected $field;

	protected $validator;


	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}

	public function field($field, $value='')
	{
		$this->field = [$field, $value];

		$this->validator = new ValidationBuilder();

		return $this->validator;
	}

}