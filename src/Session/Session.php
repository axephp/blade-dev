<?php

namespace Blade\Session;

use Blade\Interfaces\AxE\AxE;

class Session
{


	public function phpSessionDriver(AxE $axe)
	{
		return (new PhpSessionManager($axe));
	}

}