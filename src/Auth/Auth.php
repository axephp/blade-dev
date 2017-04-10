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

		$this->auths = (array)$conns;


		if (isset($conns->$default)) {
			$this->default = [$default, $conns->$default];
		}else{
			throw new Exception("Specified default authentication '$default' not found.", 516);	
		}

		$this->auths['default'] = $conns->$default;

	}


	public function getAuth($auth)
	{
		return $this->auths[$auth];
	}


	public function getDefaultAuth()
	{
		return $this->default;
	}


	public function using($authentication = 'default')
	{
		if (isset($this->guard[$authentication])) {
			return $this->guard[$authentication];

		}elseif (array_key_exists($authentication, $this->auths)) {
			return $this->setup($authentication);

		}else{
			return false;
		}
	}	



	protected function setup($auth)
	{
		$conf = $this->auths[$auth];

		$class = ucfirst($conf->driver).'Driver';

		$pro = 'make'.ucfirst($conf->provider).'Provider';

		$provider = $this->$pro($conf);

		$driver = new $class($this->default[0].'Auth', $provider, $this->axe->resolve('session'), $this->axe->resolve('route'));

		$element = new AuthElement($driver, $conf->login_page, $conf->post_login_page, $conf->user);

		$element->prepare();

		$this->guard[$auth] = $element;

		return $element;
	}


	protected function makeDatabaseProvider($conf)
	{
		$pro = 'Blade\Auth\\'.ucfirst($conf->provider).'Provider';

		$provider = new $pro($this->axe->resolve('db')->using($conf->connection), $conf->table, $this->axe->resolve('hash'));

		return $provider;
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
