<?php

namespace Blade\AxE;

use Exception;

class AxE_Error extends Exception implements Throwable
{
	
	function render()
	{
		echo "aao";
	}
}