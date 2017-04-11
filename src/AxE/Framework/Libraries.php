<?php

namespace Blade\AxE\Framework;

trait Libraries
{

	public function __get($key)
	{
		if (axe()->isBound($key) || axe()->isMapped($key)) {

			$libs = (array)axe()->resolve('libs');
			if (in_array($key, array_merge($libs, array_keys($libs)))) {
				return axe()->resolve($key);
			}
		}
		
	}

}