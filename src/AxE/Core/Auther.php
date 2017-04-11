<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\AxE;

use Blade\Config\Config;

class Auther
{	


	protected $axe;


	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}


	public function run($route)
	{

		$auth = $this->axe->resolve(\Blade\Auth\Auth::class);

		$conf = $auth->getDefaultAuth()[1];

		$onload = $conf->login_compulsory;

		dump($auth->using()->getSession()->get($auth->using()->getName()));

		$auth->using()->loginWithId($auth->using()->getSession()->get($auth->using()->getName()));

		$user = $auth->using()->user();

		$page = ($route->getRequest()[0]);

		if (!$user) {
			if ($onload && $page !== $conf->login_page) {
				redirect($conf->login_page);
			}
		}

	}

}