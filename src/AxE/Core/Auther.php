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

		if (!$user) {
			if ($onload) {
				echo "You will be redirected to : ". $conf->login_page;
			}

			var_dump($axe->resolve('current'));
		}else{

		}

		dump($user);

	}

}