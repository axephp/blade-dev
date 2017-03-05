<?php

namespace Blade\AxE;

use Exception;
use Throwable;

class AxE_Error extends Exception implements Throwable
{
	
	function render($request, $ex)
	{
		echo "aao";
	}
}