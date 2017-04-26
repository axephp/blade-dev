<?php

namespace Blade\Database;

use Blade\Validation\Validatable;

trait FormModel
{

	use Validatable;
	
	function fromForm($args = [])
	{	
		if (Validatable::validate($args)) {
			parent::__construct($args);
		}		
	}

}