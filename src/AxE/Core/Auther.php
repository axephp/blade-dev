<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\AxE;

use Blade\Config\Config;

class Auther
{

	public function run(AxE $axe)
	{

		$auth = $axe->resolve(\Blade\Auth\Auth::class);

		$conf = $auth->getDefaultAuth()[1];

		$onload = $conf->login_compulsory;

		if ($onload) {
			echo "You will be redirected to : ". $conf->login_page;
		}

		//dump($auth);

	}

}