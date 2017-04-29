<?php

namespace Blade\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Blade\Interfaces\AxE\AxE;


class Database
{
	
	protected $axe;

	protected $instance;

	protected $default;

	protected $connections;


	function __construct(AxE $axe)
	{
		$capsule = new Capsule;

		$capsule->setAsGlobal();

		// Setup the Eloquent ORM
		$capsule->bootEloquent();

		$this->instance = $capsule;
		$this->axe = $axe;

		$this->boot();

	}

	public function boot()
	{
		$config = $this->axe->config('database');

		$default = $config->default;
		$conns = $config->connections;

		$this->connections = $conns;

		if (isset($conns->$default)) {
			$this->default = [$default, (array)$conns->$default];
		}else{
			throw new Exception("Specified default connection '$default' not found.", 516);	
		}

		$this->add($this->default[1], 'default');
		
	}


	public function capsule()
	{
		return $this->capsule;
	}


	public function getInstance()
	{
		return $this->instance;
	}


	public function instance()
	{
		return $this->instance;
	}


	public function add($connection, $name)
	{
		$this->instance->addConnection($connection, $name);
	}

	public function using($connection = 'default')
	{
		if (!is_null($this->instance->connection($connection))) {
			return $this->instance->connection($connection);

		}elseif (array_key_exists($connection, (array)$this->connections)) {
			$this->add((array)$this->connections->$connection, $connection);
			return $this->using($connection);

		}else{
			return $this->instance;
		}
	}
}