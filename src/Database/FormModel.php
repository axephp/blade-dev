<?php

namespace Blade\Database;


trait FormModel
{
	
	function fromForm($args = [])
	{	
		if (parent::validate($args)) {
			parent::__construct($args);
		}		
	}

}