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


	public function run($route, $response)
	{

		$this->axe->resolve('db');

		$auth = $this->axe->resolve(\Blade\Auth\Auth::class);

		if (!$this->axe->config('site')->uses_auth) {
			$this->axe->map('auth', $auth);
			return;
		}

		
		# For Default Auth
		$conf = $auth->getDefaultAuth()[1];
		$onload = $conf->login_compulsory;
		$user = $auth->using()->loginWithIdOnce($auth->using()->getSession()->get($auth->using()->getName()));

		$this->axe->map('auth', $auth);

		$page = ($route->getRequest()[0]);

		// MULTI-LOGIN ISSUE HERE, SESSION BASED ISSUE AND LOGGING MULTIPLE SESSIONS : TODO : Later

		if (!$user){
			if ($onload && $page !== $conf->login_page) {
				redirect($conf->login_page);
			}
		}else{
			if ($page == $conf->login_page) {
				redirect($conf->post_login_page);
			}
		}

		# End For Default Auth

		$param = $route->getParameters()['requests'];

		if (isset($param[0]) && $param[0] == 'logout'){

			$authC = (isset($param[1])) ? $param[1] : $auth->getDefaultAuth()[0];

			$auth->using($authC)->logout();

			redirect($conf->login_page);

		}

		//return $route;

	}

}