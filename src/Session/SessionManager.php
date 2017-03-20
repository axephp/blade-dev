<?php

namespace Blade\Session;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\AxE;
use Blade\Interfaces\AxE\Manager as IManager;

class SessionManager extends Manager implements IManager
{

	function run(AxE $axe)
	{
		
		$config = $axe->config('session');

		$driverName = $config->driver;
		$method = $driverName.'SessionDriver';

		$session = $axe->resolve(\Blade\Session\Session::class)->$method($axe);

		$axe->map('session', $session);

		$session->checkForExpiry($config->lifetime);
		
		$session->encrypt($config->encrypt);

	}
}
