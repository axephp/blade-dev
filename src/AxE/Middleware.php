<?php

namespace Blade\AxE;

use ReflectionClass;
use Exception;

class Middleware
{

	private $axe;
	
	function __construct(\Blade\AxE\AxE $axe)
	{
		$this->axe = $axe;
	}

	public function __get($key)
	{
		if ($this->axe->isBound($key) || $this->axe->isMapped($key)) {

			$libs = (array)$this->axe->resolve('libs');
			if (in_array($key, array_merge($libs, array_keys($libs)))) {
				return $this->resolve($key);
			}
		}
		
	}
}