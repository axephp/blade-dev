<?php

namespace Blade\AxE\Framework;

use Blade\Routing\CompiledRoute;

class Controller
{

	protected $loadBag = [];

	protected $vars = [];

	public function __set($key, $value='')
	{
		$this->vars[$key] = $value;
	}


	public function __get($key)
	{
		if (axe()->isBound($key) || axe()->isMapped($key)) {

			$libs = (array)axe()->resolve('libs');
			if (in_array($key, array_merge($libs, array_keys($libs)))) {
				return &axe()->resolve($key);
			}
		}
		
	}

	public function router($compiled, $path){

		$old = $compiled->getPath();
		$new = $compiled;
		$new->setPath($old.DIRECTORY_SEPARATOR.$path);
		return $new;

	}

}