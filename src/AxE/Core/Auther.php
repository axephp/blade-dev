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

		$auth = $configs->authentications->{$configs->default};

		$onload = $auth->login_compulsory;

		if ($onload) {
			echo "You will be redirected to : ". $auth->login_page;
		}
		
		dump($auth);

	}

}