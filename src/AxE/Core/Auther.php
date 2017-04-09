<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\AxE;

use Blade\Config\Config;

class Auther
{

	public function run(AxE $axe)
	{

		$configs = $axe->config('auth');

		$conf = $configs->authentications->{$configs->default};

		$onload = $conf->login_compulsory;

		$auth = $axe->resolve(\Blade\Auth\Auth::class);

		if ($onload) {
			echo "You will be redirected to : ". $conf->login_page;
		}

		dump($auth);

	}

}