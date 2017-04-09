<?php

namespace Blade\Auth;

use ReflectionClass;
use Exception;

use Blade\Interfaces\AxE\AxE;

class Auth
{


	protected $axe;

	protected $default;

	protected $auths = [];

	protected $guard = [];

	function __construct(AxE $axe)
	{

		$this->axe = $axe;

		$this->boot();

	}

	public function boot()
	{
		
		$config = $this->axe->config('auth');

		$default = $config->default;
		$conns = $config->authentications;

		$this->auths = $conns;

		if (isset($conns->$default)) {
			$this->default = [$default, (array)$conns->$default];
		}else{
			throw new Exception("Specified default authentication '$default' not found.", 516);	
		}


	}


	public function getAuth($auth)
	{
		return $this->auths[$auth];
	}


	public function getDefaultAuth()
	{
		return $this->getAuth($this->default);
	}


	public function using($authentication = 'default')
	{
		if (!is_null($this->guard[$authentication])) {
			return $this->guard[$authentication];

		}elseif (in_array($authentication, (array)$this->auths)) {
			$this->setup($authentication);
			return $this->using($authentication);

		}else{
			return $this->default;
		}
	}



	protected function setup($auth)
	{
		$conf = $this->auths[$auth];

		$element = new AuthElement($conf->driver, $conf->login_page, $conf->post_login_page, $conf->user);

		$element->prepare();

		$this->guard[$auth] = $element;
	}


	public function loginPage()
	{
		//
	}


	public function registerPage()
	{
		//
	}

}