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

		$user = $auth->using()->getUser();

		$request = (new \Blade\Http\Request())->requests();

		dump($request);

		if (!$user) {
			if ($onload) {
				redirect($conf->login_page);
			}
		}

	}

}