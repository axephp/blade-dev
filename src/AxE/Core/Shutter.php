<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

class Shutter // implements ICore
{

	public function run(AxE $axe)
	{
		register_shutdown_function(array($this, 'shutTheAxEUp'));
	}

	public function shutTheAxEUp()
	{
		//Things to do when shutting down
		echo "I'm shutting";
	}

}