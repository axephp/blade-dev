<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\AxE;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


class Shutter
{

	protected $axe;

	public function run(AxE $axe)
	{
		$this->axe = $axe;
		register_shutdown_function(array($this, 'shutTheAxEUp'));
	}

	public function shutTheAxEUp()
	{
		//Things to do when shutting down

		$error = error_get_last();

		var_dump($error);

		
	}

}