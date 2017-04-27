<?php

namespace Blade\Validation;

use Exception;

use Blade\AxE\Framework\Libraries;

trait Validatable
{

	use Libraries;

	private $validated = false;


	public function validate($args)
	{
	
		return $this->validated = $this->validator->validate($args);
	}

	public function validated()
	{
		return $this->validated;
	}

	public function validationMessage()
	{
		return $this->validator->message();
	}

}