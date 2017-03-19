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

		// Setup the Eloquent ORM
		$capsule->bootEloquent();

		$this->instance = $capsule;
		$this->axe = $axe;

	}

	public function boot()
	{
		$config = $this->axe->config('database');

		$default = $config->default;
		$conns = $config->connections;

		$this->connections = $conns;

		if (isset($conns->$default)) {
			$this->default = [$default, $conns->$default];
		}else{
			throw new Exception("Specified default connection '$default' not found.", 516);	
		}

		$this->add((array)$this->default, 'default');
		
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

	public function use($connection = 'default')
	{
		if (!is_null($this->instance->connection($connection))) {
			return $this->instance->connection($connection);

		}elseif (in_array($connection, (array)$this->connections)) {
			$this->add($this->connections->$connection, $connection);
			return $this->use($connection);

		}else{
			return $this->instance;
		}
	}
}