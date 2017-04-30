<?php

namespace Blade\Database;

use Blade\Validation\Validatable;

trait FormModel
{
	
	use Validatable;

	private $validator;

	function fromForm($args = [])
	{	

		if (method_exists(__CLASS__, 'rules')) {
			$this->validator = axe()->resolve('validator');
			$this->rules();
		}

		if (!empty($args)) {
			if ($this->validate($args)) {
				parent::__construct($args);
			}
		}else{
			parent::__construct([]);
		}
		
	}

}