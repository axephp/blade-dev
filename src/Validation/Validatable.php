<?php

namespace Blade\Validation;

use Exception;

trait Validatable
{

	private $validated = false;


	public function validate($args)
	{

		parent::rules();

		$this->validated = true;
		
		return $this->validator->validate($args);
	}

	public function validated()
	{
		return $this->validated;
	}

	public function validationMessage()
	{
		$this->validator->message();
	}

}