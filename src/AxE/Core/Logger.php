<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\AxE;

class Logger
{

	public function run(AxE $axe)
	{

		// TODO: Logging tasks
		$axe->register(['logs' => \Blade\Log\Log::class]);
	}

}