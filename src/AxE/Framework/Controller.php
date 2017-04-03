<?php

namespace Blade\AxE\Framework;

use Blade\Routing\CompiledRoute;

class Controller
{

	protected $loadBag = [];

	private $axe;

	protected $vars = [];

	function __construct(\Blade\AxE\AxE $axe)
	{
		$this->axe = $axe;
	}


	public function __set($key, $value='')
	{
		$this->vars[$key] = $value;
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

	public function router($compiled, $path){

		$old = $compiled->getPath();
		$compiled->setPath($old.DIRECTORY_SEPARATOR.$path);
		return $compiled;

	}

}